(function($){

    function string_to_slug (str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to   = "aaaaeeeeiiiioooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str;
    }

    $(document).ready(function () {
        $('body').on('change', '.js-field-title', function() {
            let $slug = $(this).parent().parent().next().find('.js-field-slug');
            if (typeof $slug !== 'undefined'){
                if ($slug.val() === '') {
                    $slug.val(string_to_slug($(this).val()));
                }
            }
        });

        $('body').on('change', '.js-pg-disposition', function() {
            let tr = $(this).parent().parent();

            const value = $(this).val();
            const config = {
                'big_image' : {
                    'js-pg-media' : true,
                    'js-pg-feature' : false,
                    'js-pg-textColumn1' : true,
                    'js-pg-textColumn2' : false
                },
                'small_image' : {
                    'js-pg-media' : true,
                    'js-pg-feature' : false,
                    'js-pg-textColumn1' : true,
                    'js-pg-textColumn2' : false
                },
                'one_column' : {
                    'js-pg-media' : false,
                    'js-pg-feature' : true,
                    'js-pg-textColumn1' : true,
                    'js-pg-textColumn2' : false
                },
                'two_column' : {
                    'js-pg-media' : false,
                    'js-pg-feature' : true,
                    'js-pg-textColumn1' : true,
                    'js-pg-textColumn2' : true
                },
            };

            if (typeof config[value] !== 'undefined') {
                for (const [selector, visible] of Object.entries(config[value])) {
                    let field = tr.find('.' + selector);
                    if (selector === 'js-pg-media') {
                        field = field.parent().parent();
                    }

                    if (visible === true) {
                        field.show();
                    } else {
                        field.hide();
                    }
                }
            }
        });
        $('body .js-pg-disposition').trigger('change');

        $('.js-datepicker').datepicker({
            altField: "#datepicker",
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'yy-mm-dd',
        });

        $('body').on('click', '.js-datepicker', function() {
            $('.js-datepicker').datepicker({
                altField: "#datepicker",
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem.',
                dateFormat: 'yy-mm-dd',
            });
        })
    });
})($);