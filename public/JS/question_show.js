var $container = $('js-vote-arrows');
$container.find('vote-up').on('click', function (e) {
    e.preventDefault();

    var $link = $(e.currentTarget);
    console.log($container)

    $.ajax({
        url: '/commentaire/1/vote/' + $link.data('direction'),
        method: 'POST'

    }).then(function (data) {
        console.log(data.votes);
        $container.find('.js-vote-total').text(data.votes);
    });
});
