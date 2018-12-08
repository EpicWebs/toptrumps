				<div class="clear"></div>
		</div>
	</div>
<?php
	if(get_field('third_party_scripts', 'option')) {
		the_field('third_party_scripts','option');
	}
?>
<?php wp_footer(); ?>
<script type="text/javascript">
	<?php
		$cards = new WP_Query(
			array(
				"post_type" => "cards",
				"post_status" => "publish",
				"fields" => 'ids',
				"order" => 'ASC',
				"orderby" => "rand",
				"posts_per_page" => -1,
			) 
		);

		if(isset($cards->posts)) {
			$cards = $cards->posts;

			$total_cards = count($cards);

			$your_cards = array_slice($cards, 0, $total_cards / 2);
			$opponent_cards = array_slice($cards, $total_cards / 2);

			?>
			var your_cards = <?php echo json_encode($your_cards); ?>;
			var opponent_cards = <?php echo json_encode($opponent_cards); ?>;
			var maximum_clicks = <?php echo floor( ( count($your_cards) + count($opponent_cards)) / 2 ); ?>;
			var current_clicks = 0;
			var current_turn = "yours";
			<?php
		}
	?>

	// Setup the board
	get_card_data("#your-card", your_cards);
	get_card_data("#opponents-card", opponent_cards);

	function get_card_data(element_id, cards) {
		var card_id = cards[0];

		if(element_id == "#your-card") {
			your_cards = cards.slice(1);
		} else {
			opponent_cards = cards.slice(1);
		}

		var data = {
			action: 'get-card-data',
			_wpnonce: '<?php echo wp_create_nonce( "dnd-get-card-data" ); ?>',
			card_id: card_id,
		}

		jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
			render_card_data(jQuery.parseJSON(response), element_id);
		});
	}

	function render_card_data(card, element_id) {
		// Card details
		jQuery(element_id).find(".card__name").html(card["name"]);
		jQuery(element_id).find(".card__image").prop("src", card["image_url"]);
		jQuery(element_id).find(".card__description").html(card["description"]);

		if(element_id == "#your-card") {
			// Stats
			jQuery(element_id).find(".card__stats__strength").children("a").html(card["strength"]);
			jQuery(element_id).find(".card__stats__dexterity").children("a").html(card["dexterity"]);
			jQuery(element_id).find(".card__stats__constitution").children("a").html(card["constitution"]);
			jQuery(element_id).find(".card__stats__intelligence").children("a").html(card["intelligence"]);
			jQuery(element_id).find(".card__stats__wisdom").children("a").html(card["wisdom"]);
			jQuery(element_id).find(".card__stats__charisma").children("a").html(card["charisma"]);
		} else {
			jQuery(element_id).find(".card__stats__strength").children("span").html(card["strength"]);
			jQuery(element_id).find(".card__stats__dexterity").children("span").html(card["dexterity"]);
			jQuery(element_id).find(".card__stats__constitution").children("span").html(card["constitution"]);
			jQuery(element_id).find(".card__stats__intelligence").children("span").html(card["intelligence"]);
			jQuery(element_id).find(".card__stats__wisdom").children("span").html(card["wisdom"]);
			jQuery(element_id).find(".card__stats__charisma").children("span").html(card["charisma"]);
		}
	}

	function stat_value_challenge(stat_type, stat_value, your_cards, opponent_cards) {
		jQuery("#your-card").find(".card__stats").find("a").addClass("disabled");

		jQuery("#opponents-card").children(".card").removeClass("card--hidden");
		jQuery("#opponents-card").find(".card__stats").find(".card__stats__" + stat_type).children("span").addClass("selected");

		var opponent_stat_value = jQuery("#opponents-card").find(".card__stats").find(".card__stats__" + stat_type).children("span").html();

		var opponent_score = parseInt(jQuery("#opponent-score").children("span").html());
		var your_score = parseInt(jQuery("#your-score").children("span").html());

		// Display the result of who won/lost the current turn
		who_won(opponent_stat_value, stat_value, opponent_score, your_score);

		setTimeout(function() {
			if(current_turn == "yours") {
				current_turn = "opponent";
			} else {
				current_turn = "yours";
			}

			if(current_clicks >= maximum_clicks) {
				// Display the final score
				end_game_score();
			} else {
				jQuery(".card--lost").removeClass("card--lost");
				jQuery(".card--win").removeClass("card--win");

				get_card_data("#your-card", your_cards);
				get_card_data("#opponents-card", opponent_cards);

				jQuery(".selected").removeClass("selected");

				if(current_turn == "yours") {
					jQuery("#opponents-card").children(".card").addClass("card--hidden");
					jQuery("#your-card").find(".card__stats").find("a").removeClass("disabled");
				} else {
					setTimeout(function() {
						// Your opponents turn to select a stat
						stat_value_challenge_opponent();
					}, 2000);
				}
			}
		}, 4000);
	}

	function stat_value_challenge_opponent() {
		var opponent_stat_value = 0;
		var opponent_stat_type = "strength";

		jQuery("#opponents-card").find(".card__stats").find("dd").children("span").each(function() {
			if(parseInt(jQuery(this).html()) > opponent_stat_value) {
				opponent_stat_value = parseInt(jQuery(this).html());
				opponent_stat_type = jQuery(this).parent().prop("class");
				opponent_stat_type = opponent_stat_type.toString();
				opponent_stat_type = opponent_stat_type.replace("card__stats__","");
			}
		});

		jQuery("#opponents-card").find(".card__stats").find(".card__stats__" + opponent_stat_type).children("span").addClass("selected");
		jQuery("#your-card").find(".card__stats").find(".card__stats__" + opponent_stat_type).children("a").addClass("selected");

		var stat_value = parseInt(jQuery("#your-card").find(".card__stats").find(".card__stats__" + opponent_stat_type).children("a").html());

		var opponent_score = parseInt(jQuery("#opponent-score").children("span").html());
		var your_score = parseInt(jQuery("#your-score").children("span").html());

		// Display the result of who won/lost the current turn
		who_won(opponent_stat_value, stat_value, opponent_score, your_score);

		current_clicks++;

		setTimeout(function() {
			if(current_turn == "yours") {
				current_turn = "opponent";
			} else {
				current_turn = "yours";
			}

			if(current_clicks >= maximum_clicks) {
				// Display the final score
				end_game_score();
			} else {
				jQuery(".card--lost").removeClass("card--lost");
				jQuery(".card--win").removeClass("card--win");

				get_card_data("#your-card", your_cards);
				get_card_data("#opponents-card", opponent_cards);

				jQuery("#opponents-card").children(".card").addClass("card--hidden");
				jQuery(".selected").removeClass("selected");
				jQuery("#your-card").find(".card__stats").find("a").removeClass("disabled");
			}
		}, 4000);
	}

	jQuery(".card__stats").on("click", "a", function(event) {
		event.preventDefault();

		if(!jQuery(this).hasClass("disabled")) {
			var stat_value = parseInt(jQuery(this).html());
			var stat_type = jQuery(this).data("stat-type");

			jQuery(this).addClass("selected");

			current_clicks++;
			
			// Calculate who won/lost
			stat_value_challenge(stat_type, stat_value, your_cards, opponent_cards);
		}
	});

	function who_won(opponent_stat_value, stat_value, opponent_score, your_score) {
		// You lose!
		if(opponent_stat_value > stat_value) {
			opponent_score = opponent_score + 1;

			jQuery("#opponent-score").children("span").html(opponent_score);

			animate_card_combat("#opponents-card");
		}

		// You win!
		if(opponent_stat_value < stat_value) {
			your_score = your_score + 1;

			jQuery("#your-score").children("span").html(your_score);

			animate_card_combat("#your-card");
		}

		// It's a draw!
		if(opponent_stat_value == stat_value) {
			jQuery("#opponents-card").addClass("card--lost");
			jQuery("#your-card").addClass("card--lost");
		}
	}

	function end_game_score() {
		jQuery(".card--lost").removeClass("card--lost");
		jQuery(".card--win").removeClass("card--win");
		jQuery(".game-instructions").remove();

		var current_opponent_score = parseInt(jQuery("#opponent-score").children("span").html());
		var current_your_score = parseInt(jQuery("#your-score").children("span").html());

		jQuery("#opponents-card").children().remove();
		jQuery("#your-card").children().remove();

		jQuery("#opponents-card").append("<div class='final-score'><strong>Opponents Score:</strong> " + current_opponent_score + "</div>");
		jQuery("#your-card").append("<div class='final-score'><strong>Your Score:</strong> " + current_your_score + "</div>");
	}

	function animate_card_combat(element) {
		if(element == "#your-card") {
			jQuery(element).animate({"top":"40px"}, 400, function() {
				jQuery(element).animate({"top":"-20px"}, 200, function() {
					jQuery("#opponents-card").addClass("card--lost");
					jQuery("#your-card").addClass("card--win");

					jQuery(element).animate({"top":"0px"}, 800);
				});
			});
		} else {
			jQuery(element).animate({"top":"-40px"}, 400, function() {
				jQuery(element).animate({"top":"20px"}, 200, function() {
					jQuery("#opponents-card").addClass("card--win");
					jQuery("#your-card").addClass("card--lost");

					jQuery(element).animate({"top":"0px"}, 800);
				});
			});
		}
	}
</script>
</body>
</html>