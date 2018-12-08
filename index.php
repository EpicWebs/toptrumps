<?php get_header(); ?>
<article id="game-table">
    <div id="opponents-card" data-card-id="">
        <div class="card card--opponent card--hidden">
            <span id="opponent-score" class="card__label">Score: <span>0</span></span>
            <h2 class="card__name"></h2>
            <img class="card__image" src="">
            <section class="card__stats">
                <dl>
                    <dt>Strength</dt>
                    <dd class="card__stats__strength"><span></span></dd>
                    <dt>Dexterity</dt>
                    <dd class="card__stats__dexterity"><span></span></dd>
                    <dt>Constitution</dt>
                    <dd class="card__stats__constitution"><span></span></dd>
                    <dt>Intelligence</dt>
                    <dd class="card__stats__intelligence"><span></span></dd>
                    <dt>Wisdom</dt>
                    <dd class="card__stats__wisdom"><span></span></dd>
                    <dt>Charisma</dt>
                    <dd class="card__stats__charisma"><span></span></dd>
                </dl>
            </section>
            <p class="card__description"></p>
        </div>
    </div>
    <div id="your-card" data-card-id="">
        <div class="card">
            <span id="your-score" class="card__label">Score: <span>0</span></span>
            <h2 class="card__name"></h2>
            <img class="card__image" src="">
            <section class="card__stats">
                <dl>
                    <dt>Strength</dt>
                    <dd class="card__stats__strength"><a data-stat-type="strength" href="#"></a></dd>
                    <dt>Dexterity</dt>
                    <dd class="card__stats__dexterity"><a data-stat-type="dexterity" href="#"></a></dd>
                    <dt>Constitution</dt>
                    <dd class="card__stats__constitution"><a data-stat-type="constitution" href="#"></a></dd>
                    <dt>Intelligence</dt>
                    <dd class="card__stats__intelligence"><a data-stat-type="intelligence" href="#"></a></dd>
                    <dt>Wisdom</dt>
                    <dd class="card__stats__wisdom"><a data-stat-type="wisdom" href="#"></a></dd>
                    <dt>Charisma</dt>
                    <dd class="card__stats__charisma"><a data-stat-type="charisma" href="#"></a></dd>
                </dl>
            </section>
            <p class="card__description"></p>
        </div>
    </div>
    <p class="game-instructions">Click a statistic value to begin the game.</p>
</article>
<?php get_footer(); ?>