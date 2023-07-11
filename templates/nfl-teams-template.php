<?php
/*
Template Name: NFL Teams
*/

get_header();

$teams = fetch_nfl_teams();

?>

<main class="homepageBanner">
    <div class="overlay--dark">
        <div class="container content" itemscope itemtype="http://schema.org/WebPage">
            <header>
                <h1 itemprop="name headline">NFL Team Finder</h1>
                <h4 itemprop="author publisher" itemscope itemtype="http://schema.org/Organization"><span itemprop="name">ACME Sports</span></h4>
            </header>
            <section itemprop="mainContentOfPage">
                <?php
                if ($teams) {
                    // Create an array of team conferences from the $teams array, if it already exists then don't add it to the array
                    $conferences = array();
                    $divisions = array();
                    foreach ($teams as $team) {
                        if (!in_array($team['conference'], $conferences)) {
                            array_push($conferences, $team['conference']);
                        }
                        if (!in_array($team['division'], $divisions)) {
                            array_push($divisions, $team['division']);
                        }
                    }

                    // Sort $teams by conference and then by division
                    usort($teams, function ($a, $b) {
                        if ($a['conference'] == $b['conference']) {
                            return $a['division'] <=> $b['division'];
                        }
                        return $a['conference'] <=> $b['conference'];
                    });
                ?>


                    <nav aria-label="Conference Filter" class="row conferenceFilter">
                        <?php foreach ($conferences as $i => $conference) : ?>
                            <div class="col-12 col-sm-4 col-md-2 mr-2">
                                <button class="btn btn-light conferenceFilterButton <?= ($i == 0 ? 'active' : '') ?>" data-conference="<?= $i ?>"><?= $conference ?></button>
                            </div>
                        <?php endforeach; ?>
                    </nav>


                    <nav aria-label="Division Filter" class="row divisionFilter">
                        <button class="btn btn-light divisionFilterButton col-4 col-sm-3 col-md-2 active" data-division="all" href="#">All</button>
                        <?php foreach ($divisions as $i => $division) : ?>
                            <button class="btn btn-light divisionFilterButton col-4 col-sm-3 col-md-2" data-division="<?= $division ?>" href="#"><?= $division ?></button>
                        <?php endforeach; ?>
                    </nav>

                    <?php foreach ($conferences as $i => $conference) : ?>
                        <section class="teamConference teamConference--<?= $i ?>" <?= $i > 0 ? ' style="display:none;"' : '' ?> itemscope itemtype="http://schema.org/SportsTeam">
                            <h2 class="teamConferenceName"><?= $conference ?></h2>
                            <?php foreach ($divisions as $division) : ?>
                                <div class="row teamList teamList--<?= $division ?>">
                                    <?php foreach ($teams as $team) :
                                        if ($team['conference'] == $conference && $team['division'] == $division) : ?>
                                            <article class="col-12 col-sm-6 col-md-3 mb-3" itemscope itemtype="http://schema.org/SportsTeam">
                                                <a href="/nfl-teams/<?= $team['nickname'] ?>" class="teamLink" itemprop="url">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <img src="/wp-content/uploads/2023/07/nfl2.png" alt="<?= $team['display_name'] ?>" class="teamLogo" itemprop="logo">
                                                            <h3 class="card-header" itemprop="name"><?= $team['nickname'] ?></h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <h4 class="card-title" itemprop="alternateName"><?= $team['display_name'] ?></h4>
                                                            <div class="card-title teamDivision" itemprop="memberOf" itemscope itemtype="http://schema.org/SportsOrganization">
                                                                <span itemprop="name"><?= $team['division'] ?></span>
                                                                <meta itemprop="memberOf" content="<?= $conference ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </article>
                                    <?php endif;
                                    endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </section>
                <?php endforeach;
                }
                ?>
            </section>

        </div>
    </div>
</main>

<?php
get_footer();
?>