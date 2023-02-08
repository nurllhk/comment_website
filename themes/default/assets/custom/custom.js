const site_url = window.location.origin;
var timer = null;
var search = null;
var data_table = null;
var user_control_timer = null;
var review_timer = null;
var chat_info_interval = null;
var chat_messages_interval = null;
var chat_last_scroll = true;
var notification_audio = new Audio(''+site_url+'/uploads/notification.mp3');
var notification_completed = false;
var msg_notification_completed = false;
var load_image = ''+site_url+'/uploads/1x1.gif';
var review_banner_mobile = ''+site_url+'/uploads/banner_mobile.webp';
var review_banner_desktop = ''+site_url+'/uploads/banner_desktop.webp';
function error(error_text)
{
	var data = '<div class="alert alert-danger" style="word-break: break-word;"><i class="fa fa-window-close"></i> '+error_text+' </div>';
	return data;
}
function m_alert(type,title,text,button=false,link=false)
{
		if(link)
		{
			  Swal.fire({
			  icon: type,
			  title: title,
			  html: text,
			  showConfirmButton: true,
			  backdrop : false,
			  confirmButtonText: button
			  }).then((result) => {
			  if (result.isConfirmed) {
				  window.location.href = site_url;
			  } 
			  }); 
		}
		else
		{
			  if(button)
			  {
				  Swal.fire({
				  icon: type,
				  title: title,
				  html: text,
				  showConfirmButton: true,
				  backdrop : false,
				  confirmButtonText: button
				  });
			  }
			  else
			  {
				  Swal.fire({
				  icon: type,
				  title: title,
				  html: text,
				  showConfirmButton: false
				  });
			  }
		}
}

function scroll_div(id) {
		$('html, body').animate({
		scrollTop: $(""+id+"").offset().top
		}, 0);
}
function readImageURL(elm){
        var product_image = $(elm).val();
        $("#product_image_name").val(product_image);
}

function reviewRating(review_id, rating,el) {
	var type = 'review_rating';
    $.ajax({
        type: "POST",
        url: site_url+'/ajax',
        timeout: 40000,
        data: { type, review_id, rating },
        dataType: 'json',
		cache: false,
        success: function (data) {
            let result = data.result;
            let message = data.message;

            if (result) {
				
				$(el).find('span').html(data.total_count);
				
            } else  {
				
				m_alert('warning',message.title,message.content,'Tamam');
            }
        },
        error: function () {
			
				m_alert('warning','Hata','Bir hata oluştu lütfen tekrar deneyin.','Tamam');
        }
    });
}


function commentRating(comment_id, rating,el) {
	var type = 'comment_rating';
    $.ajax({
        type: "POST",
        url: site_url+'/ajax',
        timeout: 40000,
        data: { type, comment_id, rating },
        dataType: 'json',
		cache: false,
        success: function (data) {
            let result = data.result;
            let message = data.message;

            if (result) {
				
				$(el).find('.total').html(data.total_count);

            } else  {
				
                m_alert('warning',message.title,message.content,'Tamam');
            }
        },
        error: function () {
			
				m_alert('warning','Hata','Bir hata oluştu lütfen tekrar deneyin.','Tamam');
        }
    });
}

function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = '<div class="select2-result-repository clearfix">' +
                '<div class="select2-result-repository__title">' + repo.text + '</div></div>';


            return markup;
}
function formatRepoSelection (repo) 
{
            return repo.text || repo.id;
}

function user_control()
{
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=user_control&csrf_token='+csrf_token+'',
			dataType: 'json',
			cache: false,
			success: function (data) {
				if(data.status)
				{
					if(data.have_notification)
					{
						if(!notification_completed)
						{
							
							$('.account_notifications_nav .account_notification_nav_icon').addClass('fa-beat').addClass("text-danger");
							
							notification_audio.play();
							notification_completed=true;
						}
					}
					if(data.have_message)
					{
						if(!msg_notification_completed)
						{
							
							$('.account_messages_nav .account_messages_nav_icon').addClass('fa-beat').addClass("text-danger");
							
							notification_audio.play();
							msg_notification_completed=true;
						}
					}
					$('.user_balance').html(data.balance);
				}
			}
	});
	user_control_timer = setTimeout(user_control,5000);
}

function review_pay()
{
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var review_id = $('meta[name="review-id"]').attr('content');
	$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=review_payment&csrf_token='+csrf_token+'&id='+review_id+'',
			dataType: 'json',
			cache: false,
			success: function (data) {
				if(data.status)
				{
					
				}
			}
	});
}

function chat_messages()
{
			var csrf_token = $('meta[name="csrf-token"]').attr('content');
			
			$.ajax({
					type: "POST",
					url: site_url+'/ajax',
					data: 'type=chat_messages&csrf_token='+csrf_token+'',
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						
						if(data.status)
						{
							$('.chat_users').html(data.chat_info.messages);
							chat_messages_interval = window.setTimeout(chat_messages, 3000);
						}
						else
						{
							window.clearTimeout(chat_messages_interval);
						}
						
					}
			});
}

function chat_scroll_before()
{
	var client_height = $('.chat_messages')[0].clientHeight;
	var scroll_top = $('.chat_messages').scrollTop();
	var current_scroll = scroll_top + client_height;
	var scroll_height = $('.chat_messages').prop("scrollHeight");
	if(current_scroll==scroll_height)
	{
		chat_last_scroll = true;
	}
	else
	{
		chat_last_scroll = false;
	}
}
function chat_scroll(type=false)
{

	var scroll_height = $('.chat_messages').prop("scrollHeight");
	
	if(type || chat_last_scroll)
	{
		
		$('.chat_messages').scrollTop(scroll_height);
		
	}
}
function chat_info(scroll=false)
{
		var chat_current_user = $('.chat_current_user').val();
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		var form_data = $(this).serialize();
		$.ajax({
				type: "POST",
				url: site_url+'/ajax',
				data: 'type=chat_info&csrf_token='+csrf_token+'&id='+chat_current_user,
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					
					if(data.status)
					{
						chat_scroll_before();
						$('.chat_users').html(data.chat_info.messages);
						$('.chat_current_user_detail .user_status').removeClass('user_online user_offline').addClass(data.chat_info.to_user_status);
						$('.chat_current_user_detail .last_seen_info').html(data.chat_info.to_user_last_seen);
						$('.chat_messages').html(data.chat_info.current_user_messages);
						chat_scroll(scroll);
						chat_info_interval = window.setTimeout(chat_info, 3000);
					}
					else
					{
						m_alert('warning','Hata',data.msg,'Tamam');
						window.clearTimeout(chat_info_interval);
					}
					
				},
				error: function () {
						m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
				}
		});
}
function chat_form_smileys(msg)
{
			
		msg = msg.replace(':)','\uD83D\uDE42'); //&#128578;
		msg = msg.replace(':(','\uD83D\uDE41'); //&#128577;
		msg = msg.replace(':/','\uD83D\uDE2D'); //&#128557;
		msg = msg.replace(':P','\uD83D\uDE1C'); //&#128540;
		msg = msg.replace(';)','\uD83D\uDE09'); //&#128521;
		msg = msg.replace(':D','\uD83D\uDE02'); //&#128514;
		msg = msg.replace(':@','\uD83D\uDE21'); //&#128545;
		return msg;
}
function getCaret(el) { 
  if (el.selectionStart) { 
	return el.selectionStart; 
  } else if (document.selection) { 
	el.focus(); 

	var r = document.selection.createRange(); 
	if (r == null) { 
	  return 0; 
	} 

	var re = el.createTextRange(), 
		rc = re.duplicate(); 
	re.moveToBookmark(r.getBookmark()); 
	rc.setEndPoint('EndToStart', re); 

	return rc.text.length; 
  }  
  return 0; 
}

function user_reviews_list(page_no=1)
{
		$('.user_reviews_list').html('<div class="alert alert-info mb-3"><i class="fa fa-spinner fa-spin"></i> Lütfen bekleyiniz incelemeleriniz getiriliyor..</div>');
		var form_data = $('.user_reviews_search_form').serialize();
		$.ajax({
        type: "POST",
        url: site_url+'/ajax',
        timeout: 40000,
        data: 'type=user_reviews_list&page_no='+page_no+'&'+form_data,
		cache: false,
        success: function (data) {

            $('.user_reviews_list').html(data);
        },
        error: function () {
			
				m_alert('warning','Hata','Bir hata oluştu lütfen tekrar deneyin.','Tamam');
        }
		});
}

// USER_REVIEWS_LIST

$(document).on('submit', '.user_reviews_search_form', function (e) {
	
	e.preventDefault();
	
	user_reviews_list();
});

$(document).on('change', '.user_reviews_search_form', function (e) {
	
	e.preventDefault();
	
	user_reviews_list();
});

$(document).on('click', '.user_reviews_list .page-link', function (e) {
	
	e.preventDefault();
	
	user_reviews_list($(this).attr('rel'));
});

// CHAT_USER

$(document).on('keyup', '.chat_form_content', function (e) {

	if (e.keyCode == 13 && e.shiftKey) 
	{
	   var content = this.value;
	   var caret = getCaret(this);
	   this.value = content.substring(0,caret)+"\n"+content.substring(carent,content.length-1);
	   e.stopPropagation();
   
	}
	else if(e.keyCode == 13)
	{
		$('.chat_form_send').submit();
	}
	 
	$(this).val(chat_form_smileys($(this).val()));

});
$(document).on('click', '.chat_form_smiley', function (e) {
	
	e.preventDefault();
	selected_smiley = $(this).attr('rel');
	chat_msg = $('.chat_form_content').val();
	new_msg = ''+chat_msg+''+selected_smiley;
	$('.chat_form_content').val(chat_form_smileys(new_msg));

});
$(document).on('submit', '.chat_form_send', function (e) {
	
	e.preventDefault();
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var form_data = $(this).serialize();
	$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=chat_send&csrf_token='+csrf_token+'&'+form_data,
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				if(data.status)
				{
					chat_scroll_before();
					$('.chat_form_content').val('');
					$('.chat_users').html(data.chat_info.messages);
					$('.chat_current_user_detail .user_status').removeClass('user_online user_offline').addClass(data.chat_info.to_user_status);
					$('.chat_current_user_detail .last_seen_info').html(data.chat_info.to_user_last_seen);
					$('.chat_messages').html(data.chat_info.current_user_messages);
					chat_scroll(true);
				}
				else
				{
					m_alert('warning','Hata',data.msg,'Tamam');
				}
			},
			error: function () {
					m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
			}
	});
});

$(document).on('click', '.chat_user_block', function (e) {
	
	e.preventDefault();
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var chat_current_user = $('.chat_current_user').val();
	
	Swal.fire({
	  customClass: {
		confirmButton: 'btn btn-danger me-2',
		cancelButton: 'btn btn-success me-2'
	  },
	  buttonsStyling: false,
	  html: 'Bu kişiyi engellemek istediğinden eminmisin ?',
	  showCancelButton: true,
	  confirmButtonText: 'Evet',
	  cancelButtonText: 'Hayır',
	}).then((result) => {
	  if (result.isConfirmed) {
		
		$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=chat_user_block&csrf_token='+csrf_token+'&id='+chat_current_user,
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				if(data.status)
				{
					window.location.reload();
				}
				else
				{
					m_alert('warning','Hata',data.msg,'Tamam');
				}
			},
			error: function () {
					m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
			}
		});
		
	  }
	});
	
	

});

$(document).on('click', '.chat_user_block_delete', function (e) {
	
	e.preventDefault();
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var chat_current_user = $('.chat_current_user').val();
	
	Swal.fire({
	  customClass: {
		confirmButton: 'btn btn-danger me-2',
		cancelButton: 'btn btn-success me-2'
	  },
	  buttonsStyling: false,
	  html: 'Bu kişinin engelini kaldırmak istediğine eminmisin ?',
	  showCancelButton: true,
	  confirmButtonText: 'Evet',
	  cancelButtonText: 'Hayır',
	}).then((result) => {
	  if (result.isConfirmed) {
		
		$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=chat_user_block_delete&csrf_token='+csrf_token+'&id='+chat_current_user,
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				if(data.status)
				{
					window.location.reload();
				}
				else
				{
					m_alert('warning','Hata',data.msg,'Tamam');
				}
			},
			error: function () {
					m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
			}
		});
		
	  }
	});
	
	

});

$(document).on('click', '.chat_delete', function (e) {
	
	e.preventDefault();
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	var chat_current_user = $('.chat_current_user').val();
	
	Swal.fire({
	  customClass: {
		confirmButton: 'btn btn-danger me-2',
		cancelButton: 'btn btn-success me-2'
	  },
	  buttonsStyling: false,
	  html: 'Bu konuşma geçmişini silmek istediğine eminmisin ?',
	  showCancelButton: true,
	  confirmButtonText: 'Evet',
	  cancelButtonText: 'Hayır',
	}).then((result) => {
	  if (result.isConfirmed) {
		
		$.ajax({
			type: "POST",
			url: site_url+'/ajax',
			data: 'type=chat_delete&csrf_token='+csrf_token+'&id='+chat_current_user,
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				if(data.status)
				{
					window.location.reload();
				}
				else
				{
					m_alert('warning','Hata',data.msg,'Tamam');
				}
			},
			error: function () {
					m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
			}
		});
		
	  }
	});
	
	

});





// USER_ACTIONS

$(document).on('click', '.user_follow', function (e) {
			
			e.preventDefault();
			
			var csrf_token = $('meta[name="csrf-token"]').attr('content');
			var id = $(this).attr('data-user-id');
			var remove = $(this).attr('data-remove');
			var div = $(this);
			var div_closest = $(this).closest('.user_actions');
			$.ajax({
					type: "POST",
					url: site_url+'/ajax',
					data: 'type=user_follow&csrf_token='+csrf_token+'&id='+id,
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						if(data.status)
						{
							if(data.user_follow.followed)
							{
								$(div_closest).find('.user_follow').removeClass('followed').addClass('followed');
								$(div_closest).find('.user_follow_icon').html('<i class="fa fa-check-square"></i>');
								$('.user_follow_text').html('Takip');
								
							}
							else
							{
								$(div_closest).find('.user_follow').removeClass('followed');
								$(div_closest).find('.user_follow_icon').html('<i class="fa fa-plus-circle"></i>');
								$(div_closest).find('.user_follow_text').html('Takip Et');
							}
							
							
							
							$('.user_followers_info').html(data.user_follow.followers);
							if(remove!='false')
							{
								$(div).closest('.friendship_user').remove()
							}
						}
						else
						{
							m_alert('warning','Hata',data.msg,'Tamam');
						}
					},
					error: function () {
							m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
					}
			});
});

$(document).on('click', '.user_block_delete', function (e) {
			
			e.preventDefault();
			
			var csrf_token = $('meta[name="csrf-token"]').attr('content');
			var id = $(this).attr('data-user-id');
			var div = $(this);
			
			Swal.fire({
			  customClass: {
				confirmButton: 'btn btn-danger me-2',
				cancelButton: 'btn btn-success me-2'
			  },
			  buttonsStyling: false,
			  html: 'Bu kişinin engelini kaldırmak istediğine eminmisin ?',
			  showCancelButton: true,
			  confirmButtonText: 'Evet',
			  cancelButtonText: 'Hayır',
			}).then((result) => {
			  if (result.isConfirmed) {
				
				$.ajax({
					type: "POST",
					url: site_url+'/ajax',
					data: 'type=chat_user_block_delete&csrf_token='+csrf_token+'&id='+id,
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						if(data.status)
						{
							$(div).closest('.friendship_user').remove();
						}
						else
						{
							m_alert('warning','Hata',data.msg,'Tamam');
						}
					},
					error: function () {
							m_alert('warning','Hata','İşlem gerçeleştirilirken bir hata oluştu, lütfen tekrar deneyin.');
					}
				});
				
			  }
			});
});

// SUPPORT_TYPE_CHANGE

$(document).on("change", '.support_type', function (event) {
	
	if($(this).val()=='İnceleme İşlemleri')
	{
		$('.support_review_id').show();
	}
	else
	{
		$('.support_review_id').hide();
	}
        
});

// TAB_DATA_TABLE

$(document).on("click", '.tab_datatable', function (event) {
	
	setTimeout(function() { data_table.columns.adjust().draw(); },500);
        
});
$(document).on("change", '.balance_filter', function (event) {
	
	
		data_table.tables(['#balance_table']).columns(1).search($(this).val()).draw();
	
        
});
$(document).on('click', ".other_reviews_btn", function () {
	$('.other_reviews').append('<div class="col-xl-12 col-sm-12 text-center other_reviews_loading"><i class="fa fa-spinner fa-spin text-brand fs-2"></i></div>');
	let page_no = $(this).attr('data-page');
	let new_page_no = Number(page_no)+1;
	$.ajax({
							type: "POST",
							url: site_url+'/ajax',
							data: {

								'type' : 'other_reviews',
								'page' : page_no

							},
							cache: false,
							success: function(data){

								 $('.other_reviews').append(data);
								 $('.other_reviews_loading').remove();
								 $('.other_reviews_btn').attr('data-page',new_page_no);

							}

	});
});

// SEARCH

$(document).on('click', ".mobile_search_open", function () {
	$('.mobile_search').find('input').focus();
});

$(document).on('keyup', '.desktop_search input[type=search]', function (el) {
		var this_val = $(this).val();
		clearTimeout(timer);
		$('.desktop_search').addClass("open");

        var str = $(".desktop_search").find('.search_input').val();
		if (str.length>= 4) {
			$(".desktop_search").find(".search__result-cover").find('ul').html("<li>Aranıyor...</li>");
       timer = setTimeout(function(){

					
					
					
					 var search =  $.ajax({
							type: "POST",
							url: site_url+'/ajax',
							cache: false,
							data: {

								'type' : 'product_search',
								'q' : this_val

							},
							success: function(data){

								 $(".desktop_search").find(".search__result").css("display", "block");

								 $(".desktop_search").find(".search__result-cover").find('ul').html(data);

							}

						});
					

           

        }, 1200);
		}
		else
		{
			$(".desktop_search").find(".search__result").css("display", "block");
			$(".desktop_search").find(".search__result-cover").find('ul').html("<li>En az 4 karakter yazın.</li>");
		}
    
		
});
$(document).on('keyup', '.mobile_search input[type=search]', function (el) {
		var this_val = $(this).val();
		clearTimeout(timer);
		$('.mobile_search').addClass("open");

        var str = $(".mobile_search").find('.search_input').val();
		if (str.length>= 4) {
			$(".mobile_search").find(".search__result-cover").find('ul').html("<li>Aranıyor...</li>");
		timer = setTimeout(function(){

					
					
					
					 var search =  $.ajax({
							type: "POST",
							url: site_url+'/ajax',
							cache: false,
							data: {

								'type' : 'product_search',
								'q' : this_val

							},
							success: function(data){

								 $(".mobile_search").find(".search__result").css("display", "block");

								 $(".mobile_search").find(".search__result-cover").find('ul').html(data);

							}

						});
					

           

        }, 1200);
		}
		else
		{
			$(".mobile_search").find(".search__result").css("display", "block");
			$(".mobile_search").find(".search__result-cover").find('ul').html("<li>En az 4 karakter yazın.</li>");
		}
    
		
});

$(document).on('keyup', '.user_reviews_search', function (el) {
		
		clearTimeout(timer);
		if ($('.user_reviews_search').val().length>= 3) {
			 timer = setTimeout(function(){
			var search =  $.ajax({
								type: "POST",
								url: site_url+'/ajax',
								cache: false,
								data: {

									'type' : 'user_reviews_search',
									'q' : $('.user_reviews_search').val()

								},
								success: function(data){

									$('.user_reviews').html(data);

								}

			});
			 });
		}
    
		
});
$(document).on('keyup', '.review_product_search', function (el) {
		
		clearTimeout(timer);
		$(".review_product_search").addClass("open");

        var str = $('.review_product_search').val();
		if (str.length>= 4) {
			$(".product__result-cover").find('ul').html("<li>Aranıyor...</li>");
       timer = setTimeout(function(){

					
					
					
					 var search =  $.ajax({
							type: "POST",
							url: site_url+'/ajax',
							cache: false,
							data: {

								'type' : 'review_product_search',
								'q' : $('.review_product_search').val()

							},
							success: function(data){

								$(".review_product_results").css("display", "block");

								 $(".product__result-cover").find('ul').html(data);

							}

						});
					

           

        }, 1200);
		}
		else
		{
			$(".review_product_results").css("display", "block");
			$(".product__result-cover").find('ul').html("<li>En az 4 karakter yazın.</li>");
		}
    
		
});
$(document).on('click', function (el) {
		 
		  if((el.target.className=='form-control search_input desktop_search_input') && $('.desktop_search_input').val().length>3)
		  {
			
			  $(".desktop_search").addClass("open");
			  $(".desktop_search").find('.search__result').css("display", "block");
		  }
		  else
		  {
			  $(".desktop_search").removeClass("open");
			  $(".desktop_search").find('.search__result').slideUp(200); 
		  }
		
});
$(document).on('click', function (el) {
		 
		  if((el.target.className=='form-control search_input mobile_search_input') && $('.mobile_search_input').val().length>3)
		  {
			  $(".mobile_search").addClass("open");
			  $(".mobile_search").find('.search__result').css("display", "block");
		  }
		  else
		  {
			  $(".mobile_search").removeClass("open");
			  $(".mobile_search").find('.search__result').slideUp(200); 
		  }
		
});

$(document).on('change', '.product_search', function(){
            window.location.href=$(this).val();
}); 


// PRODUCT_CATEGORIES_SLIDER

$(document).on('click', ".product_categories_next", function () {
	
	var visible_width =  $('.product_categories').width();
	var total_width =  $('.product_categories').prop('scrollWidth');
	var scroll_width = visible_width;
	var left_position = $('.product_categories').scrollLeft();
	$(".product_categories").animate({
     scrollLeft: left_position + scroll_width
	}, 1000);
});

$(document).on('click', ".product_categories_prev", function () {
	
	var visible_width =  $('.product_categories').width();
	var total_width =  $('.product_categories').prop('scrollWidth');
	var scroll_width = visible_width;
	var left_position = $('.product_categories').scrollLeft();
	$(".product_categories").animate({
     scrollLeft: left_position - scroll_width
	}, 1000);
});

// REFERENCE_LINK_COPY

$(document).on('click', ".reference_link_copy", function () {
	
	var $tempElement = $("<input>");
	$("body").append($tempElement);
	$tempElement.val($('.reference_link').text()).select();
	document.execCommand("Copy");
	$(this).text('Kopyalandı!');
	$tempElement.remove();
	
});

// FIRST_REVIEW_STEP


$(document).on('click', '.first_review_step_card .first_review_step_by_step', function (el) {
	
	var step_type = $(this).attr('data-type');
	var all_step = $('.first_review_step_card');
	var step = $('.first_review_step_card.active').closest('.first_review_step_card');
	var next_step = $('.first_review_step_card.active').closest('.first_review_step_card').next();
	var prev_step = $('.first_review_step_card.active').closest('.first_review_step_card').prev();
	if(step_type=='next')
	{
		if(next_step.length)
		{
			all_step.removeClass('active');
			next_step.addClass('active');
			setTimeout(function(){ scroll_div(".first_review_step_card"); }, 200);
		}
	}
	else
	{
		if(prev_step.length)
		{
			all_step.removeClass('active');
			prev_step.addClass('active');
			setTimeout(function(){ scroll_div(".first_review_step_card"); }, 200);
		}
	}

	
});


$(document).on('submit','.first_review_step_form', function(e){
		e.preventDefault();
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		var first_review_step_url = $('.first_review_step_url').val();
		$.ajax({
			type: 'POST',
			url: site_url+'/ajax',
			data: 'type=first_review_step&csrf_token='+csrf_token+'',
			dataType: 'json',
			cache: false,
			success: function(data) {
				if(data.status)
				{
					Swal.fire({
					title: 'Tebrikler',
					icon: 'success',
					text: 'İnceleme ekleme ilk adımını başarıyla tamamladınız, lütfen bekleyiniz...',
					allowOutsideClick: false,
					allowEscapeKey: false,
					showConfirmButton:false
					});
					
					setTimeout(function(){ window.location.href=first_review_step_url; }, 3000);
				}
				else
				{
					m_alert('warning','Hata',data.msg,'Tamam');
				}
			}
		})
});


// REVIEW_IMAGE_LIGHTBOX

$(document).on("click", '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
});

// LOGIN_REGISTER_FORM

$(document).on('submit','.login_form', function(e){
			e.preventDefault();
			var data = $('.login_form').serialize();
			$.ajax({
				type: 'POST',
				url: site_url+'/ajax',
				data: 'type=login&'+data+'&time='+$.now()+'',
				dataType: 'json',
				cache: false,
				success: function(data) {
					if(data.status)
					{
						$('.login_result').html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Giriş başarılı, Lütfen bekleyiniz.</div>');
						window.location.href=site_url;
					}
					else
					{
						$('.login_result').html(error(data.error));
						scroll_div(".login_result");
					}
				}
			})
});
$(document).on('submit','.register_form', function(e){
			e.preventDefault();
			var data = $('.register_form').serialize();
			$.ajax({
				type: 'POST',
				url: site_url+'/ajax',
				data: 'type=register&'+data+'&time='+$.now()+'',
				dataType: 'json',
				cache: false,
				success: function(data) {
					if(data.status)
					{
						$('.register_result').html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Kayıt başarıyla tamamlandı, giriş yapılıyor. Lütfen bekleyiniz.</div>');
						window.location.href=site_url;
					}
					else
					{
						$('.register_result').html(error(data.error));
						scroll_div(".register_result");
					}
				}
			})
});

// REVIEW_AND_COMMENT_LIKE

$(document).on('click', '.review_like', function (el) {
        reviewRating($(this).attr('data-id'), 'up',$(this));
});

$(document).on('click', '.review_dislike', function (el) {
        reviewRating($(this).attr('data-id'), 'down',$(this));
});
$(document).on('click', '.comment_like', function (el) {
        commentRating($(this).attr('data-id'), 'up',$(this));
});

$(document).on('click', '.comment_dislike', function (el) {
        commentRating($(this).attr('data-id'), 'down',$(this));
});

// COMMENT_ADD_AND_REPLY

$(document).on('click', '.comment_reply', function (el) {
        var answered_u_id = $(this).attr('data-answered-user');
        var answered_user_name = $(this).attr('data-answered-username');
		$('.answered_u_id').val(answered_u_id);
		$("htm,body").animate({
        scrollTop: $("#add_comment").offset().top
		}, 500);
		setTimeout(function()
		{
			$('.comment_textarea').attr('placeholder','@'+answered_user_name+' adlı kullanıcıya cevap veriyorsunuz');
			$('.comment_textarea').focus();
		},500);
});

$(document).on('submit', '#add_comment', function (e) {
       
	e.preventDefault();
	var form_data = $(this).serialize();
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	form_data = form_data + '&csrf_token=' + csrf_token;
    $.ajax({
        type: "POST",
        url: site_url+'/ajax',
        timeout: 40000,
        data: form_data,
        dataType: 'json',
		cache: false,
        success: function (data) {

            if (data.status) {
				
				$('.answered_u_id').val('0');
				$('.comment_textarea').val('');
				
                m_alert('success','Başarılı',data.msg,'Tamam');
				
				$('.answered_u_id').val('0');
				$('.comment_textarea').attr('placeholder','Bu inceleme hakkında ne düşünüyorsunuz ?');
            } else  {
                
				m_alert('warning','Hata',data.msg,'Tamam');
            }
        },
        error: function () {
			
				m_alert('warning','Hata','Bir hata oluştu lütfen tekrar deneyin.','Tamam');
        }
    });
});

$( document ).ready(function() {
	
	
	if($('.user_messages_container').length)
	{
		chat_messages();
	}
	
	if($('.user_reviews_search_form').length)
	{
		user_reviews_list();
		
	}
	
	if($('.chat_current_user_detail').length)
	{
		chat_info(true);
	}
	
	if($('.account_notifications_nav').length)
	{
		user_control_timer = setTimeout(user_control,5000);
	}
	if($('meta[name="review-id"]').length)
	{
		review_timer = setTimeout(review_pay,4000);
	}
	
	
	

	if($('.chat_form_content').length)
	{
		var cursorFocus = function(elem) {
		  var x = window.scrollX, y = window.scrollY;
		  elem.focus();
		  setTimeout(function() { window.scrollTo(x, y); }, 800);
		}
		
		$(document).on('click', '.chat_form_content', function (event) {
        
		event.preventDefault();
		
		cursorFocus(document.getElementById('chat_form_content'));

		
		
		});
	
	}
			

	if ($('.datatable').length){
		
	data_table = $('.datatable').DataTable({

	charset: "UTF-8",
	responsive: true,
	aaSorting:[],
	language:
	{
		"sDecimal":        ",",
		"sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
		"sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
		"sInfoEmpty":      "Kayıt yok",
		"sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
		"sInfoPostFix":    "",
		"sInfoThousands":  ".",
		"sLengthMenu":     "_MENU_ Görüntüle",
		"sLoadingRecords": "Yükleniyor...",
		"searchPlaceholder": "Arama...",
		"sProcessing":     "İşleniyor...",
		"sSearch":         "",
		"sZeroRecords":    "Eşleşen kayıt bulunamadı",
		"oPaginate": {
		"sFirst":    "İlk",
		"sLast":     "Son",
		"sNext":     "Sonraki",
		"sPrevious": "Önceki"

		},

		"oAria": {
		"sSortAscending":  ": artan sütun sıralamasını aktifleştir",
		"sSortDescending": ": azalan sütun sıralamasını aktifleştir"

		},

		"select": {

		"rows": {
		"_": "%d kayıt seçildi",
		"0": "",
		"1": "1 kayıt seçildi"

		}

		}
	}

	});
	}

//SELECT2

	$('.select2').select2({
	   "language": {
		   "noResults": function(){
			   return "Sonuç bulunamadı.";
		   }
	   },
	   theme: "bootstrap-5",
	   escapeMarkup: function (markup) {
			return markup;
	   },
	   allowClear: true

	});

        // Initialize
	$('.brand_search').select2({
		theme: "bootstrap-5",
		placeholder:'Marka arayın, marka listede bulunmuyorsa "diğer" seçebilirsiniz.',
		ajax: {
			url: site_url+'/ajax',
			dataType: 'json',
			type: 'post',
			delay: 250,
			data: function (params) {
				return {
					type: 'brand_search',
					q: params.term,
					time: $.now()
				};
			},
			processResults: function (data, params) {


				return {
					results: data.items
				};
			},
			cache: false
		},
		"language": {
		   "noResults": function(){
			   return "Sonuç bulunamadı.";
		   },
		   "inputTooShort": function(){
			   return "Lütfen en az 3 karakter yazın.";
		   },
		   "searching": function(){
			   return "Aranıyor...";
		   }
	   },
		escapeMarkup: function (markup) { return markup; }, 
		minimumInputLength: 3,
		templateResult: formatRepo, 
		templateSelection: formatRepoSelection
	});
	
	// PRODUCT_CATEGORIES_DRAG
	
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	});
	 const product_categories_slider = document.querySelector(".product_categories");
	 if(product_categories_slider)
	 {
      let isDown = false;
      let isDragged = false;
      let startX;
      let scrollLeft;

      product_categories_slider.addEventListener("mousedown", e => {
        isDown = true;
        product_categories_slider.classList.add("active");
        startX = e.pageX - product_categories_slider.offsetLeft;
        scrollLeft = product_categories_slider.scrollLeft;
      });
      product_categories_slider.addEventListener("mouseleave", () => {
        isDown = false;
        product_categories_slider.classList.remove("active");
      });
      product_categories_slider.addEventListener("mouseup", (e) => {
        isDown = false;
        product_categories_slider.classList.remove("active");
        isDragged =  false;
      });
      product_categories_slider.addEventListener("mousemove", e => {
        if (!isDown) return;
        isDragged =  true;
        e.preventDefault();
        const x = e.pageX - product_categories_slider.offsetLeft;
        const walk = (x - startX) * 2;
        product_categories_slider.scrollLeft = scrollLeft - walk;
      });
	 }

});



