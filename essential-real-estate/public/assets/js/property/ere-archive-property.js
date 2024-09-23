(function ($) {
    'use strict';
    $(document).ready(function () {
        function ere_archive_property() {
            $('span', '.archive-property-action .view-as').each(function() {
                var $this = $(this);
                if(window.location.href.indexOf("view_as") > -1 ){
                    if(window.location.href.indexOf("view_as="+$this.data('view-as')) > -1) {
                        $this.addClass('active');
                    }
                } else {
                    if($('.ere-property', '.ere-property-wrap').hasClass($this.data('view-as'))) {
                        $this.addClass('active');
                    }
                }
                var handle = true;
                $this.on('click', function(event){
                    var $view = $(this),
                        $view_as = $view.data('view-as'),
                        $property_list = $view.closest('.ere-property-wrap').find('.ere-property'),
                        $ajax_url = $view.closest('.view-as').data('admin-url');
                    event.preventDefault();
                    if($view.hasClass('active') || !handle) {
                        return false;
                    } else {
                        handle = false;
                        $view.closest('.view-as').find('span').removeClass('active');
                        $view.addClass('active');
                        $property_list.fadeOut();
                        setTimeout(function () {
                            if($view_as=='property-list') {
                                $property_list.removeClass('property-grid').addClass('property-list list-1-column');
                            } else {
                                $property_list.removeClass('property-list list-1-column').addClass('property-grid');
                            }
                            $property_list.fadeIn('slow');
                        }, 400);
                        $.ajax({
                            url: $ajax_url,
                            data: {
                                action: 'ere_property_set_session_view_as_ajax',
                                view_as: $view_as
                            },
                            success: function () {
                                handle = true;
                            },
                            error: function () {
                                handle = true;
                            }
                        });
                    }
                });
            });
        }
        ere_archive_property();
        function ere_property_paging_control() {
            $('.paging-navigation', '.ere-property').each(function () {
                var $this = $(this);
                if($this.find('a.next').length === 0) {
                    $this.addClass('next-disable');
                } else {
                    $this.removeClass('next-disable');
                }
            });
        }
        ere_property_paging_control();

        $("#ere_save_search").click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var $form = $('#ere_save_search_form');
            var $ajax_url=$this.data( 'ajax-url');
            $.ajax({
                url: $ajax_url,
                data: $form.serialize(),
                method: $form.attr('method'),
                dataType: 'JSON',
                beforeSend: function () {
                    $this.children('i').remove();
                    $this.append('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    if (typeof(response.success) == 'undefined') {
                        ERE.login_modal();
                    }
                    if (response.success) {
                        $this.children('i').removeClass('fa-spinner fa-spin');
                        $this.children('i').addClass('fa-check');
                    }
                },
                error: function () {
                    $this.children('i').removeClass('fa-spinner fa-spin');
                    $this.children('i').addClass('fa-exclamation-triangle');
                },
                complete: function () {
                    $this.children('i').removeClass('fa-spinner fa-spin');
                }
            });
        });
    });
})(jQuery);