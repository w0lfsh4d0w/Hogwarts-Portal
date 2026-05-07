<?php
$header = "Home";
include 'partials/header.view.php';
include 'partials/nav.view.php';
?>

<main>

    <!-- Home section -->
    <section class="container-fluid home" id="home">
        <div class="row home-row">
            <div class="col-6 home-content">
                <h1>Hogwarts School</h1>
                <p>
                    An ancient castle of mystery and magic, where enchanted halls whisper with secrets of the past.
                    Here, young witches and wizards are shaped into legends through spellbinding lessons, hidden chambers,
                    and the timeless rivalry of the four noble houses.
                </p>
            </div>
            <div class="col-6 home-image">
                <img src="/assets/img/sorting-hat.png" alt="home">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="container " id="about">
        <div class="row about-row">
            <div class="col-6 about-content">
                <h2>About</h2>
                <p>
                    The Hogwarts School of Witchcraft and Wizardry is a prestigious educational institution known for its
                    wizarding
                    training and magic studies. It is located in the magical world of Hogwarts, where students are
                    trained to
                    become wizards and witches.
                </p>
            </div>
            <div class="col-6 about-image">
                <img src="/assets/img/castle.jpg" alt="about">
            </div>
        </div>

    </section>


    <!-- Services Section -->
    <section class="container mb-5" id="services">
        <div class="row service-row">
            <div class="col-6 about-image">
                <img src="/assets/img/sorting-hat.png" alt="services">
            </div>
            <div class="col-6 about-content">
                <h2>Services</h2>
                <p>
                    Hogwarts School of Witchcraft and Wizardry offers a wide range of services to help students become
                    wizards and witches. These services include:
                </p>
            </div>
        </div>
    </section>


</main>

<?php
include 'partials/footer.view.php';
?>