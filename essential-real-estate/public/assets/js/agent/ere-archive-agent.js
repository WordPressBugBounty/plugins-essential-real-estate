(function ($) {
	'use strict';
	$(document).ready(function () {
		function ere_archive_agent() {
			$('span', '.archive-agent-action .view-as').each(function() {
				var $this = $(this);
				if(window.location.href.indexOf("view_as") > -1 ){
					if(window.location.href.indexOf("view_as="+$this.data('view-as')) > -1) {
						$this.addClass('active');
					}
				} else {
					if($('.ere-agent', '.ere-archive-agent').hasClass($this.data('view-as'))) {
						$this.addClass('active');
					}
				}
				var handle = true;
				$this.on('click', function(event){
					var $view = $(this),
						$view_as = $view.data('view-as'),
						$agent_list = $view.closest('.ere-archive-agent').find('.ere-agent'),
						$ajax_url = $view.closest('.view-as').data('admin-url');
					if($view.hasClass('active') || !handle) {
						event.preventDefault();
						return false;
					} else {
						$view.closest('.view-as').find('span').removeClass('active');
						$view.addClass('active');
						$agent_list.fadeOut();
						setTimeout(function () {
							if ($view_as == 'agent-list') {
								$agent_list.removeClass('agent-grid').addClass('agent-list list-1-column');
							} else {
								$agent_list.removeClass('agent-list list-1-column').addClass('agent-grid');
							}
							$agent_list.fadeIn('slow');
						}, 400);
						$.ajax({
							url: $ajax_url,
							data: {
								action: 'ere_agent_set_session_view_as_ajax',
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
		ere_archive_agent();
		function ere_archive_agent_paging_control() {
			$('.paging-navigation', '.ere-archive-agent').each(function () {
				var $this = $(this);
				if($this.find('a.next').length === 0) {
					$this.addClass('next-disable');
				} else {
					$this.removeClass('next-disable');
				}
			});
		}
		ere_archive_agent_paging_control();
	});
})(jQuery);