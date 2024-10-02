<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
 <!--begin::Post-->
 <div class="content flex-row-fluid" id="kt_content"> 
	<?php
	 $total_rows = 0;
	 $tablenya = $tabledb;
	 $exclude = $exclude_table;
	 include APPPATH . "views/navbar_header.php";
	?>
   <!--begin::Row-->
   <div class="row gx-6 gx-xl-9">
     <!--begin::Col-->
     <div class="col-lg-12">
       <!--begin::Summary-->
       <div class="card card-custom gutter-b example example-compact">
         <div class="row">
           <div class="col-sm-12">
             <div class="card-header tabbable" style="padding:0;display:none" id="ul_menu_header">
               <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" role="tablist" style="margin:0;margin-left:30px">
                 <li class="nav-item mt-2" id="nav-1" onClick="get_data(1,'nav-1');">
                   <a class="nav-link active" data-toggle="tab" href="javascript:;" role="tab">
                     <i class="far fa-list-alt"></i> &nbsp;Daftar<?php echo $title; ?></a>
                 </li>
                 <li class="nav-item mt-2" id="nav-2" onClick="get_data(0,'nav-2');">
                   <a class="nav-link" data-toggle="tab" href="javascript:;" role="tab">
                     <i class="far fa-trash-alt"></i> &nbsp;Terhapus</a>
                 </li>
               </ul>
             </div>
             <div class="card-body card-table">
               <div class="table-responsive table-custom">
                 <table id="datatablesskp" class="table table-striped align-middle table-row-dashed fs-6 gy-5">
                   <thead>
                     <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                       <th></th> 
						<?php
						$total_rows = 0;
						$exclude = $exclude_table;
						$query_column = $this->ortyd->getviewlistcontrol(
							$tablenya,
							$module,
							$exclude
						);
						if ($query_column) {
							$x = 1;
							foreach ($query_column as $rows_column) {
								$label_name = $this->ortyd->translate_column(
									$tablenya,
									$rows_column["name"]
								);
								if (
									$rows_column["name"] != $identity_id &&
									$rows_column["name"] != "active"
								) {
									$table_change = "'" . $tablenya . "'";
									$table_change_id = "'" . $rows_column["name"] . "'";
									$label_name_text = "'".$label_name."'";
									$editheader = '<span style="cursor:pointer" onClick="changeTitle('.$table_change .",".$table_change_id .",".$label_name_text.')"><i class="fa fa-edit"></i></span>';
									if ($this->ortyd->getAksesEditNaming() == true) {
										echo '<th data-id="'.$rows_column["name"].'">' .
											$label_name.
											$editheader.
											"</th>";
									} else {
										echo '<th data-id="'.$rows_column["name"] .'">'.
											$label_name .
											"</th>";
									}
								}
								$x++;
							}
							$total_rows = $x;
						}
						?>
                       <!--<th>Status</th><th></th> -->
                     </tr>
                   </thead>
                   <tbody></tbody>
                 </table>
               </div>
               <script type="text/javascript">
                  var table;
                  var type = 1;

                  function closeMenu() {
                    KTMenu.createInstances();
                    var menuElement = document.querySelector("#kt_menu_data");
                    var menu = KTMenu.getInstance(menuElement);
                    var item = document.querySelector("#kt_menu_data_item");
                    menu.hide(item);
                  }
                  $(document).ready(function() {
                      getHeader('<?php echo $module; ?>')
                        table = $('#datatablesskp').DataTable({
                          colReorder: true,
                          "drawCallback": function(settings) {
                            KTMenu.createInstances();
                            $("#header_data_total").html($('#dt_total').html());
                          },
                          "rowCallback": function(row, data) {
                            var key = 0;
                            for (const theArray in data) {
                              if (key == 0) {
                                $('td:eq(' + key + ')', row).addClass('dtkenolbtn');
                              }
                              if (key == 1) {
                                $('td:eq(' + key + ')', row).addClass('dtkenol');
                                break
                              }
                              key = key + 1
                            }
                          },
                          "responsive": false,
                          "scrollY": false,
                          "scrollX": true,
                          "scrollCollapse": true,
                          "processing": true,
                          "dom": '<"row"<"col-md-9 text-left"B><"col-md-3 text-right"f>>rt<"row"<"col-md-1"l><"col-md-5 text-right"i><"col-md-6"p>>',
                          "buttons": [{
                            className: 'btn-copy',
                            text: '<i class = "fas fa-copy" ></i> Salin',
                            extend: 'copy'
                          }, {
                            className: 'btn-excel',
                            text: '<i class = "far fa-file-excel" ></i> Unduh Excel',
                            extend: 'excel',
                            action: newExportAction
                          }],
                          "oLanguage": {
                            "sProcessing": "Mengambil Data ...",
                            "oPaginate": {
                              "sFirst": "<<",
                              "sPrevious": "<",
                              "sNext": ">",
                              "sLast": ">>"
                            },
                            "sSearch": '<i class = "fa fa-search" ></i>',
                            "sSearchPlaceholder": 'Cari ...',
                            "sInfo": 'Menampilkan _START_ sampai _END_ dari <span id = "dt_total" style = "display: contents;" > _TOTAL_</span>', 
							<?php
                            if ($this->ortyd->access_check_insert_data($module) && $this ->session->userdata("group_id") != 3) {
                            ?>
								"sEmptyTable" : 'Tidak ada data yang tersedia. <a href="<?php echo $linkcreate; ?>"class="">Buat Data Baru</a>', 
							<?php
                            } else { ?>
								"sEmptyTable" : 'Tidak ada data yang tersedia', 
							<?php
                            } ?>
                            //"sLengthMenu": "Menampilkan _MENU_ Entri",
                            "sInfoEmpty" : ""
                          },
                          "fixedColumns": {
                            leftColumns: 2,
                          },
                          "sPaginationType": "full_numbers",
                          "lengthMenu": [
                            [10, 50, 100, 500, 1000, -1],
                            [10, 50, 100, 500, 1000, 'All']
                          ],
                          "processing": true,
                          "serverSide": true,
                          "order": [],
                          "ajax": {
                            "url": "<?php echo base_url($linkdata); ?>",
                            "type" : "POST",
                            "data": function(d) {
                              d.active = type;
                              d.table = '<?php echo $tabledb; ?>';
                              d.csrf_ortyd_vms_name = "<?php echo $this->security->get_csrf_hash(); ?>";
                            }
                          },
                          "columnDefs": [{
                            "targets": [0, 0],
                            "orderable": false,
                            "width": "10px"
                          }],
                        }).on('column-reorder', function(e, settings, details) {
                            var datacolumnnya = [];
                            //console.log(settings.aoHeader[0])
                            var headernya = settings.aoHeader[0]
                            for (var x = 0; x<= headernya.length - 2; x++) {
                              if (typeof(headernya[x].cell.nextElementSibling.attributes) != "undefined") {
                                dataaa = headernya[x].cell.nextElementSibling.attributes;
                                if (typeof(dataaa[0]) != "undefined") {
                                  if (typeof(dataaa[0]) != null) {
                                    result = dataaa[0].nodeValue;
                                    datacolumnnya[x] = result;
                                  }
                                }
                              }
                            }
                            const myArray = datacolumnnya.toString();
                            var myJsonString = JSON.stringify(myArray);
                            console.log(myArray)
                            //console.log(details)
                            savingTableViewOrder('<?php echo $module; ?>','<?php echo $tablenya; ?>', datacolumnnya, myArray)
                            });
                        });
                      var oldExportAction = function(self, e, dt, button, config) {
                        if (button[0].className.indexOf('buttons-excel') >= 0) {
                          if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                          } else {
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                          }
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                          $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                      };
                      var newExportAction = function(e, dt, button, config) {
                        var self = this;
                        var oldStart = dt.settings()[0]._iDisplayStart;
                        dt.one('preXhr', function(e, s, data) {
                          // Just this once, load all data from the server...
                          data.start = 0;
                          data.length = 2147483647;
                          dt.one('preDraw', function(e, settings) {
                            // Call the original action function 
                            oldExportAction(self, e, dt, button, config);
                            dt.one('preXhr', function(e, s, data) {
                              // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                              // Set the property to what it was before exporting.
                              settings._iDisplayStart = oldStart;
                              data.start = oldStart;
                            });
                            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                            setTimeout(dt.ajax.reload, 0);
                            // Prevent rendering of the full data to the DOM
                            return false;
                          });
                        });
                        // Requery the server with the new one-time export settings
                        dt.ajax.reload();
                      };

                      function get_data(data, dis) {
                        $('.nav-link').removeClass("active");
                        $('#' + dis + ' a').addClass("active");
                        type = data;
                        table.draw();
                      }<?php
                      if (isset($_GET["message"])) {
                        if ($_GET["message"] == "success") {
                          ?>Swal.fire({
                            icon: 'success',
                            title: 'Berhasil ...',
                            text: 'Menyimpan data berhasil',
                          })<?php
                        } else {
                          ?>Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan ...',
                            text: 'Menyimpan data error',
                          })<?php
                        }
                      } ?>function deletedata(id) {
                        var boxdelete = bootbox.confirm({
                            title: "Confirm Action",
                            message: "Do you want to delete this data ?",
                            buttons: {
                              cancel: {
                                label: '<i class = "fa fa-times" ></i> Cancel'
                              },
                              confirm: {
                                label: '<i class = "fa fa-check" ></i> Confirm'
                              }
                            },
                            callback: function(result) {
                              if (result == true) {
                                $.post('<?php echo base_url($headurl.
                                    "/removedata"); ?>',{ id : id, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>" }, function (data) {
                                  if (data.message == "success") {
                                    table.draw();
                                    boxdelete.modal('hide');
                                    Swal.fire({
                                      icon: 'success',
                                      title: 'Berhasil ...',
                                      text: 'Hapus data berhasil',
                                    })
                                  } else {
                                    table.draw();
                                    boxdelete.modal('hide');
                                    Swal.fire({
                                      icon: 'error',
                                      title: 'Kesalahan ...',
                                      text: 'Hapus data error',
                                    })
                                  }
                                }, 'json');
                            }
                          }
                        });
                    }

                    function restoredata(id) {
                      var boxdelete = bootbox.confirm({
                          title: "Confirm Action",
                          message: "Do you want to restore this data ?",
                          buttons: {
                            cancel: {
                              label: '<i class = "fa fa-times" ></i> Cancel'
                            },
                            confirm: {
                              label: '<i class = "fa fa-check" ></i> Confirm'
                            }
                          },
                          callback: function(result) {
                            if (result == true) {
                              $.post('<?php echo base_url($headurl.
                                  "/restoredata"); ?>',{ id : id, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>" }, function (data) {
                                if (data.message == "success") {
                                  table.draw();
                                  boxdelete.modal('hide');
                                  Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil ...',
                                    text: 'Mengembalikan data berhasil',
                                  })
                                } else {
                                  table.draw();
                                  boxdelete.modal('hide');
                                  Swal.fire({
                                    icon: 'error',
                                    title: 'Kesalahan ...',
                                    text: 'Mengembalikan data error',
                                  })
                                }
                              }, 'json');
                          }
                        }
                      });
                  }
               </script>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>