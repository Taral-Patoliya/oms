
                    $('#created_on').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
					if ( ! ('content' in CKEDITOR.instances)) {
						CKEDITOR.replace('content');
					}