jQuery(document).ready(function ($) {
    $('.conferenceFilterButton').on('click', function () {
        var conference = $(this).data('conference');
        console.log(conference);
        $('.teamConference').hide();
        $('.teamConference--' + conference).show();

        // Set this button to active and remove active from other buttons
        $('.conferenceFilterButton').removeClass('active');
        $(this).addClass('active');

    });

    //Filter teams by division. North, East, South and West. Hide all teams and then show the ones that match the division.
    $('.divisionFilterButton').on('click', function () {
        var division = $(this).data('division');
        console.log(division);
        if (division == 'all') {
            $('.teamList').show();
            // Set this button to active and remove active from other buttons
            $('.divisionFilterButton').removeClass('active');
            $(this).addClass('active');
            return;
        }
        $('.teamList').hide();
        $('.teamList--' + division).show();

        // Set this button to active and remove active from other buttons
        $('.divisionFilterButton').removeClass('active');
        $(this).addClass('active');
    });
});
