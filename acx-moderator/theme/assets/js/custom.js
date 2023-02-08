
var loading = '<div class="alert bg-primary"><i class="fa fa-spinner fa-spin"></i> <span class="font-weight-semibold">Lütfen bekleyiniz yükleniyor...</span> </div>';

function review_image_upload()
{
	
            var form_data = new FormData();
		   var totalfiles = document.getElementById('review_image_files').files.length;
		   for (var index = 0; index < totalfiles; index++) {
			  form_data.append("files[]", document.getElementById('review_image_files').files[index]);
		   }
		    form_data.append("type", 'add_review_image');
		    form_data.append("t", $.now());
		 
		    $.ajax({
			type: "POST",
			url: 'ajax.php',
			timeout: 40000,
			data: form_data,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function (data) {
				let result = data.result;
			
				if (result) {
					$.each(data.links, function(k,v)
					{
					
					var di = $('<p>'); 
					var img = $("<img>").attr({src: v, style:'width:50%;margin: 0 auto;'}); 
					$('.summernote').summernote('editor.saveRange');
					$('.summernote').summernote('editor.restoreRange');
					$('.summernote').summernote('editor.focus');
										  $('.summernote').summernote('insertNode', di[0]);
										  $('.summernote').summernote('insertNode', img[0]);
					
					});
					 
				} 
				$('#review_image_input').html('<input class="form-control" id="review_image_files" name="files[]" type="file" multiple accept="image/*">');
			}
		});
}
function ajax_table(filters)
{
	
		var table_content = $('.ajax_table_content');
		table_content.html(loading);
		$.ajax({

            type: 'POST',

            url: 'ajax_table.php?time='+$.now(),
            data: filters,

            success: function(data) {

				table_content.html(data);
				

            }

        });
		
}


$(document).on('change', '.support_template_select', function(){
          
		 var moderators = ["Pınar", "Mert", "Deniz", "Gamze", "Burak", "Mehmet", "Pelin"];

		 var moderator_select = moderators[Math.floor(Math.random() * moderators.length)];
		 
		 var id = $(this).val();
		 var text_content = $('.support_template_'+id+'').html();
		 text_content = text_content.replace('{moderator}',moderator_select);
		 $('.summernote').summernote('code', '');
		 $('.summernote').summernote('code', text_content);
		 new PNotify({
			title: 'Başarılı',
			text: 'Destek şablonu başarıyla işlendi!',
			icon: 'icon-checkmark3',
			addclass: 'bg-success border-success text-white',
			type: 'success'
		});
		   
});

$(document).on('submit', '.review_detail_form', function(e){
			
		 if(!check_pay_review)
		 {
          e.preventDefault();
		  check_pay_review = true;
		  
		  swal({
			title: "Uyarı",
			text: "Para kazanma durumunu kontrol edin.",
			type: "info",
			confirmButtonClass: 'btn btn-success',
			confirmButtonText: "Tamam"
		  });
		  
		  
		  return false;
		 }
		   
});


$(document).on('change', '#review_image_files', function(){
           review_image_upload();
		   
});

$(document).on('change', '.add_comment_review', function(){
          
		 var id = $(this).val();
		 $.ajax({

            type: 'POST',

            url: 'ajax.php',
			data: 'type=add_comment_review_detail&id='+id+'',
            success: function(data) {

				$('.add_comment_review_detail').html(data);
              
				$('[data-popup="lightbox"]').fancybox({
							padding: 3
				});
            }

        })
		   
});

$(document).on('click', '.content_approve', function(){
          
		 var btn = $(this);
		 var type = $(this).attr('data-type');
		 var id = $(this).attr('rel');
		 $.ajax({

            type: 'POST',

            url: 'ajax.php',
			data: 'type='+type+'&id='+id+'',
			dataType: 'json',
            success: function(data) {
				if(data.status)
				{
					btn.closest('.card').remove();
					new PNotify({
						title: 'Başarılı',
						text: data.msg,
						icon: 'icon-checkmark3',
						addclass: 'bg-success border-success text-white',
						type: 'success'
					});
				}
				else
				{
					new PNotify({
						title: 'Hata',
						text: data.msg,
						icon: 'icon-blocked',
						addclass: 'bg-danger border-danger text-white',
						type: 'error'
					});
				}
            }

        })
		   
});

$(document).on('click', '.copy_review_reject', function (event) {
	
   var btn = $(this);
   var type = $(this).attr('data-type');
   var id = $(this).attr('rel');
   swal({
    title: "Emin misiniz ?",
    text: "Bu incelemeyi kopya nedeniyle reddediyorsunuz ?",
    type: "warning",
    showCancelButton: true,
	confirmButtonClass: 'btn btn-success',
   cancelButtonClass: 'btn btn-danger',
    confirmButtonText: "Evet",
    cancelButtonText: "Hayır"
  }).then(function (e) {
          if(e.dismiss=="cancel" || e.dismiss=="overlay")
		  {
		  }
		  else
		  {
			  if(e.value)
			  {
				$.ajax({

					type: 'POST',

					url: 'ajax.php',
					data: 'type='+type+'&id='+id+'',
					dataType: 'json',
					success: function(data) {
						if(data.status)
						{
							btn.closest('.card').remove();
							new PNotify({
								title: 'Başarılı',
								text: data.msg,
								icon: 'icon-checkmark3',
								addclass: 'bg-success border-success text-white',
								type: 'success'
							});
						}
						else
						{
							new PNotify({
								title: 'Hata',
								text: data.msg,
								icon: 'icon-blocked',
								addclass: 'bg-danger border-danger text-white',
								type: 'error'
							});
						}
					}

				});
			  }
		  }
  });          

	
});

$(document).on('click', '.plagiarism_checker', function(){
          
		review_editor_text_only = $($(".summernote").summernote("code")).text().trim();
		
		var $tempElement = $("<textarea>");
		$("body").append($tempElement);
		$tempElement.val(review_editor_text_only).select();
		document.execCommand("Copy");
		$tempElement.remove();
		new PNotify({
								title: 'Başarılı',
								text: 'İnceleme Kopyalandı!',
								icon: 'icon-checkmark3',
								addclass: 'bg-success border-success text-white',
								type: 'success'
		});
});

$(document).on('submit', '.review_image_editor_ajax', function(e){
          
		  
		e.preventDefault();
		
		
		var review_image_number = $('.review_image_number').val();
		var review_editor = $('.review_editor');
		var review_editor_clone = $('.review_editor_clone');
		review_editor_clone.html(review_editor.val());
		
		
		
		var form_data = new FormData($('.review_image_editor_ajax')[0]);
		
			 $.ajax({
				type: 'POST',
				url: 'ajax.php',
				data: form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(data) {
					if(data.result)
					{
						
						review_editor_clone.find('img').eq(review_image_number).attr('src',data.link);
						review_editor.val(review_editor_clone.html());
						$('.summernote').summernote('code',review_editor_clone.html());
						
						review_editor_clone.html('');
						$('.modal').modal('hide');

					}
					else
					{
							swal({
							title: "HATA",
							text: "Yüklenen resim geçerli değil!",
							type: "warning",
							confirmButtonClass: 'btn btn-success',
							confirmButtonText: "Tamam",
						  });
					}
				}
			})
		
		
		
		   
});


$( document ).ready(function() {



function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");
        
        // Applying the top margin on modal to align it vertically center
        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
    }
    // Align modal when it is displayed
    $(".modal").on("shown.bs.modal", alignModal);
    
    // Align modal when user resize the window
    $(window).on("resize", function(){
        $(".modal:visible").each(alignModal);
    });  


//AJAX TABLE


$('.ajax_table').each(function(e){

	var filters = $('.ajax_table_search').serialize();
	ajax_table(filters);



});


$(document).on('submit', '.ajax_table_search', function (e) {
	
e.preventDefault();


});

$(document).on('change', '.ajax_table_search', function (e) {
	
	var filters = $('.ajax_table_search').serialize();
	ajax_table(filters);


});

$(document).on('click', '.ajax_table .page-link', function (e) {


var filters = $('.ajax_table_search').serialize()+'&page_no='+$(this).attr('rel')+'';
ajax_table(filters);

});

$(document).on('keyup', '.ajax_table_search text_search', function (e) {


	e.preventDefault();
	var code = e.which;
    if(code==13)e.preventDefault();
    if(code==32||code==13||code==188||code==186){
      
		var filters = $('.ajax_table_search').serialize();
		ajax_table(filters);

	  
    } 

});

$(document).on('click', '.check_all', function () {
	
   if($(this).hasClass('checked'))
   {
	   $('.all_delete').prop('checked', false);
	   $(this).removeClass('checked');
   }
   else
   {
	$('.all_delete').prop('checked', true);
	
	$(this).addClass('checked');
   }


});





//WAITING ACTION




//BAN CHANGE

$('.ban_change').on('change', function(e) {
	if($(this).val()==1)
	{
		$('.ban_information').show();
	}
	else
	{
		$('.ban_information').hide();
	}
});

//BAN DATE CHANGE

$('.ban_date').on('change', function(e) {
	if($(this).val()=="")
	{
		$('.ban_finish_time').val('');
	}
	else
	{
		if($(this).val()==0)
		{
			$('.ban_finish_time').val('Sınırsız');
		}
		else
		{
			var date=new Date();
			date.setDate(date.getDate());
			date.setMonth(date.getMonth()+1);
			date.setMinutes(date.getMinutes() + Number($(this).val()));
			var year=date.getFullYear();
			var month=date.getMonth()
			var day=date.getDate();
			var hour=date.getHours();
			var minute=date.getMinutes();
			var second=date.getSeconds();	
			if (day < 10) {day = "0"+day;}
			if (month < 10) {month = "0"+month;}
			if (hour < 10) {hour = "0"+hour;}
			if (minute < 10) {minute = "0"+minute;}
			if (second   < 10) {second   = "0"+second;}
			var ban_finish_time = ''+day+'.'+month+'.'+year+' '+hour+':'+minute+':'+second+'';
			$('.ban_finish_time').val(ban_finish_time);
		}
	}
});

// DOCUMENT GET

var $_GET = {};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});

//DATETIME

function date_time()
{
	var date=new Date();
	date.setDate(date.getDate());
	var year=date.getFullYear();
	var month=date.getMonth()+1;
	var day=date.getDate();
	var hour=date.getHours();
	var minute=date.getMinutes();
	var second=date.getSeconds();	
    if (day < 10) {day = "0"+day;}
    if (month < 10) {month = "0"+month;}
    if (hour < 10) {hour = "0"+hour;}
    if (minute < 10) {minute = "0"+minute;}
	if (second   < 10) {second   = "0"+second;}
	date_time_t = setTimeout(date_time,1000);
	$('.date_time').html(''+day+'.'+month+'.'+year+' '+hour+':'+minute+':'+second+'');
}

var date_time_t = setTimeout(date_time,1000);

//LIGHTBOX

$('[data-popup="lightbox"]').fancybox({
            padding: 3
});


//LISTBOX

$('.listbox').bootstrapDualListbox({
});
$('.listbox2').bootstrapDualListbox({
});





//DATATABLE

$.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
});
var table = $('.datatable-button-html5-basic').DataTable({
					charset: "UTF-8",
          buttons: {            
                buttons: [
                    {
                        extend: 'copyHtml5',
                        className: 'btn btn-light',
						text: 'Kopyala'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-light'
                    },
					{
				    extend: 'print',
					 customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
					},
                    text: '<i class="icon-printer mr-2"></i> Yazdır',
                    className: 'btn btn-light',
                    exportOptions: {
                        columns: ':visible'
                    }
					}
                ]
            },
			
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
    },
	buttons: {
            copyTitle: 'Kopyalama İşlemi',
			copySuccess: {
				1: "Satırlar kopyalandı.",
				_: "%d satır kopyalandı."
			}
        }
}
        });

//DELETE ANSWER

$(document).on('click', '.delete', function (event) {
	
   event.preventDefault();
   var git = $(this).attr("href");
   swal({
    title: "Emin misiniz ?",
    text: "Bu içeriği silmek istediğinizden eminmisiniz ?",
    type: "warning",
    showCancelButton: true,
	confirmButtonClass: 'btn btn-success',
   cancelButtonClass: 'btn btn-danger',
    confirmButtonText: "Evet",
    cancelButtonText: "Hayır"
  }).then(function (e) {
          if(e.dismiss=="cancel" || e.dismiss=="overlay")
		  {
		  }
		  else
		  {
			  if(e.value)
			  {
				window.location.href=""+git+"";
			  }
		  }
  });          

	
});

//PRINT

$('.print').on('click', function(e) {
	var print = $(this).attr("rel");
   $('#'+print+'').print({
                        //Use Global styles
                        globalStyles : true,
                        //Add link with attrbute media=print
                        mediaPrint : true,
                        //Custom stylesheet
                        stylesheet : "http://fonts.googleapis.com/css?family=Inconsolata",
                        //Print in a hidden iframe
                        iframe : false,
                        //Don't print this
                        noPrintSelector : ".avoid-this",
                        //Log to console when printing is done via a deffered callback
                        deferred: $.Deferred().done(function() { console.log('Printing done', arguments); })
                    });
});	



//  DATEPICKER

if($_GET["tarih"])
{

	var tarihler = $_GET["tarih"].split(" - ");
	var st = tarihler[0];
	var ed = tarihler[1];
}
else
{
	var st = "01.01.2021";
	var ed = "30.12.2021";
}

$('.daterange-ranges').daterangepicker(
		{
			showCustomRangeLabel:false,
			startDate:st,
			endDate:ed,
			minDate: '01.01.2021',
			maxDate: '30.12.2021',
			dateLimit: { days: 60 },
			autoApply: true,
			ranges: {
				'Bugün': [moment(), moment()],
				'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Son 1 Hafta': [moment().subtract(6, 'days'), moment()],
				'Son 1 Ay': [moment().subtract(29, 'days'), moment()],
				'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
				'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			opens: 'right',
			applyClass: 'btn-sm bg-slate-600',
			cancelClass: 'btn-sm btn-light',
			locale: {
			format: 'DD.MM.YYYY',
			applyLabel: 'Uygula',
			cancelLabel: 'Kapat',
			startLabel: 'Başlangıç',
			endLabel: 'Bitiş',
			daysOfWeek: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cm','Cmts'],
			monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
			}
		},
		function(start, end) {
			$('.daterange-ranges span').html(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
		}
);

       

//SELECT2

$('.select2').select2({
   "language": {
       "noResults": function(){
           return "Sonuç bulunamadı.";
       }
   },
   escapeMarkup: function (markup) {
        return markup;
   }

});

function formatRepo (repo) {
            if (repo.loading) return repo.text;
			if(repo.type=='category')
			{
            var markup = '<div class="select2-result-repository clearfix">' +
                '<div class="select2-result-repository__title">' + repo.text + '</div></div>';
			}
			else
			{
				var markup = '<div class="select2-result-repository clearfix">' +
                '<div class="select2-result-repository__title" style="font-weight:normal">' + repo.text + '</div></div>';
			}

            return markup;
        }

        // Format selection
        function formatRepoSelection (repo) {
            return repo.text || repo.id;
        }

        // Initialize
        $('.select_search').select2({
            ajax: {
                url: 'ajax.php',
                dataType: 'json',
                type: 'post',
                delay: 250,
                data: function (params) {
                    return {
                        type: 'brand_search',
                        q: params.term
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
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
		$('.product_select_search').select2({
            ajax: {
                url: 'ajax.php',
                dataType: 'json',
                type: 'post',
                delay: 250,
                data: function (params) {
                    return {
                        type: 'product_search',
                        q: params.term
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
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });

//NOTE IMAGE INPUT

$('.note-image-input').uniform({
            fileButtonClass: 'action btn bg-warning-400'
        });
		 $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-pink-400'
        });


// SUMMERNOTE

if ($('.summernote').length){
        
  $('.summernote').summernote({
    lang: 'tr-TR',
	height:500,
	callbacks: {
					onImageUpload: function (data) {
									data.pop();
					},
					onKeydown: function(e) {
						var caracteres = $(".note-editable").text().trim().split(' ');
						var totalCaracteres = caracteres.length;

						
						$(".review_content_count").text(totalCaracteres);
		  
					},
					 onKeyup: function(e) {
						var caracteres = $(".note-editable").text().trim().split(' ');
						var totalCaracteres = caracteres.length;

						
						$(".review_content_count").text(totalCaracteres);
					},
					onPaste: function(e) {
						var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
						var caracteres = $(".note-editable").text().trim().split(' ');
						var totalCaracteres = caracteres.length;

						
						$(".review_content_count").text(totalCaracteres);
					},
					onInit: function() {
					 var caracteres = $(".note-editable").text().trim().split(' ');
						var totalCaracteres = caracteres.length;

						
						$(".review_content_count").text(totalCaracteres);
					}
                },
    cleaner:{
          action: 'both', 
          newline: '<br>', 
          icon: '<i class="note-icon">[Your Button]</i>',
          keepHtml: false,
          keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], 
          keepClasses: false,
          badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'],
          badAttributes: ['style', 'start'],
          limitChars: false, 
          limitStop: false
    }
  });
  
}

});

