<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
 <!--begin::Post-->
 <div class="content flex-row-fluid" id="kt_content"> 
			<div class="row gx-6 gx-xl-9">
			
				<div class="col-lg-6">
				
						<div class="row">	
							<div class="col-lg-12">	
								<div id="chart-containerformance" style="height:300px"></div>
							</div>
							
							<div class="col-lg-6">	
								<div id="chart-containerformance-1" style="height:300px"></div>
							</div>
							
							<div class="col-lg-6">	
								<div id="chart-containerformance-2" style="height:300px"></div>
						</div>
						
						</div>
						
						
						
				</div>	
				
				<div class="col-lg-6">	
					<div class="row">	

						<div class="col-lg-4">	
							<div id="chart-containerformance-5" style="height:300px"></div>
						</div>
						<div class="col-lg-4">	
							<div id="chart-containerformance-4" style="height:300px"></div>
						</div>
						<div class="col-lg-4">	
							<div id="chart-containerformance-7" style="height:300px"></div>
						</div>
								
						<div class="col-lg-6">	
							<div id="chart-containerformance-6" style="height:300px"></div>
						</div>
								
						<div class="col-lg-6">	
							<div id="chart-containerformance-8" style="height:300px"></div>
						</div>
					
						
						
						

					</div>
				</div>
		
				
				
						
					
		
		</div>
		
	</div>
</div>
		<script type="text/javascript">

				//$.post('<?php echo base_url('dashboard/getItemsChart'); ?>',{
					//id:1
				//}, function (data) {
				//if(data != 'null'){
					//var obj = jQuery.parseJSON(data);
					//console.log(obj);
					//if(obj.message == 'success'){	
						//FusionCharts.ready(function() {
						 // var myChart = new FusionCharts({
							//type: "pie2d",
							//renderAt: "chart-containerformance",
							//width: "100%",
							//height: "100%",
							//dataFormat: "json",
							// dataSource: {
								//chart: {
								//	caption: "Project WON",
									//"captionFont": "Arial",
								//	"captionFontSize": "14",
								//	plottooltext: "<b>$percentValue</b>  $label",
								//	"showValues": "1",
								//	showlegend: "0",
								//	showpercentvalues: "1",
								//	legendposition: "bottom",
								//	usedataplotcolorforlabels: "1",
								//	theme: "fusion",
								//	showLabels: "1",
								//	animateClockwise: "1",
								//	"pieRadius": "60",
								//	"placeValuesInside": "0",
								//	"numberScaleValue": "1000,1000,1000",
								//	"numberScaleUnit": " rb, jt, M",
								//	"decimalSeparator": ",",
								//	"thousandSeparator": ".",
								//	 valueFontSize : "10",
								//},
								//data: obj.data
							// },
							// events: {
									//dataPlotClick: function (eventObj, dataObj) {
									//console.log(dataObj)
									//viewPopData(1)
								//}
							// }
						 // }).render();
						//})	
					//}
				//}
				//})
							
							
							
				function get_dashboard_performance(project_tipe, tahun){
					
					FusionCharts.ready(function() {
						
						 $.post('<?php echo base_url($headurl.'/projectbysales'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>", csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
						
							var caption = project_tipe;
							var subCaption = "Nominal Rp.";
							
							
						var myChart2 = new FusionCharts({
						type: "msspline",
						renderAt: "chart-containerformance",
						width: "100%",
						height: "100%",
						dataFormat: "json",
						dataSource: {
							 chart: {
								caption: caption,
								"captionFont": "Arial",
									"captionFontSize": "14",
								"subCaption": subCaption,
								xaxisname: "",
								yaxisname: "",
								theme: "fusion",
								 "showValues": "1",
							  showlegend: "1",
							  legendItemFontSize:"10",
							  showpercentvalues: "1",
							  legendposition: "bottom",
							  usedataplotcolorforlabels: "1",
							  theme: "fusion",
							  showLabels: "1",
							  animateClockwise: "1",
							   "placeValuesInside": "0",
							"numberScaleValue": "1000,1000,1000",
							"numberScaleUnit": " rb, jt, M",
							"decimalSeparator": ",",
						  "thousandSeparator": ".",
						  "rotateValues": "0",
						  valueFontSize : "11",
						   showYAxisValues : 1,
						    showXAxisValues : 1,
							  },
						  "categories": [{
							"category": obj.data
						  }],
						  "dataset": obj.data5
						},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = ''
										idData = 1
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
					  }).render();
					  }
					})
					  
					  
					  
					  
					$.post('<?php echo base_url($headurl.'/projectbychannel'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
							var caption = "Project By Channel";
							var subCaption = "Number of";
							
							var myChart2 = new FusionCharts({
							type: "mscolumn2d",
							renderAt: "chart-containerformance-1",
							width: "100%",
							height: "100%",
							dataFormat: "json",
							dataSource: {
							    chart: {
									caption: caption,
									"subCaption": subCaption,
									"captionFont": "Arial",
									"captionFontSize": "14",
									plottooltext: "<b>$displayValue</b>",
								  "showValues": "0",
								  showlegend: "1",
								  showpercentvalues: "1",
								  legendposition: "bottom",
								  usedataplotcolorforlabels: "1",
								  theme: "fusion",
								  showLabels: "1",
								  labelFontSize:"11",
								  legendItemFontSize:"6",
								  animateClockwise: "1",
								  "pieRadius": "40",
								  "placeValuesInside": "0",
								  "numberScaleValue": "1000,1000,1000",
							      "numberScaleUnit": " rb, jt, M",
							      "decimalSeparator": ",",
							      "thousandSeparator": ".",
							      valueFontSize : "10",
							      "rotateValues": "1",
							  },
							  categories: [
								{
								  category: obj.data
								}
							 ],
							 dataset: obj.data5
							},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = obj
										idData = 5
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
						  }).render();
						}
					})
					
					
					$.post('<?php echo base_url($headurl.'/projectbyrecuring'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
							var caption = "Project By OTC/Recurring";
							var subCaption = "Number of";
							
							var myChart2 = new FusionCharts({
							type: "mscolumn2d",
							renderAt: "chart-containerformance-6",
							width: "100%",
							height: "100%",
							dataFormat: "json",
							dataSource: {
							    chart: {
									caption: caption,
									"subCaption": subCaption,
									"captionFont": "Arial",
									"captionFontSize": "14",
									plottooltext: "<b>$displayValue</b>",
								  "showValues": "0",
								  showlegend: "1",
								  showpercentvalues: "1",
								  legendposition: "bottom",
								  usedataplotcolorforlabels: "1",
								  theme: "fusion",
								  showLabels: "1",
								  labelFontSize:"11",
								  legendItemFontSize:"6",
								  animateClockwise: "1",
								  "pieRadius": "40",
								  "placeValuesInside": "0",
								  "numberScaleValue": "1000,1000,1000",
							      "numberScaleUnit": " rb, jt, M",
							      "decimalSeparator": ",",
							      "thousandSeparator": ".",
							      valueFontSize : "10",
							      "rotateValues": "1",
							  },
							  categories: [
								{
								  category: obj.data
								}
							 ],
							 dataset: obj.data5
							},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = obj
										idData = 7
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
						  }).render();
						}
					})
					
					$.post('<?php echo base_url($headurl.'/projectbysustain'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
							var caption = "Project By Scalling/Sustain";
							var subCaption = "Number of";
							
							var myChart2 = new FusionCharts({
							type: "mscolumn2d",
							renderAt: "chart-containerformance-8",
							width: "100%",
							height: "100%",
							dataFormat: "json",
							dataSource: {
							    chart: {
									caption: caption,
									"subCaption": subCaption,
									"captionFont": "Arial",
									"captionFontSize": "14",
									plottooltext: "<b>$displayValue</b>",
								  "showValues": "0",
								  showlegend: "1",
								  showpercentvalues: "1",
								  legendposition: "bottom",
								  usedataplotcolorforlabels: "1",
								  theme: "fusion",
								  showLabels: "1",
								  labelFontSize:"11",
								  legendItemFontSize:"6",
								  animateClockwise: "1",
								  "pieRadius": "40",
								  "placeValuesInside": "0",
								  "numberScaleValue": "1000,1000,1000",
							      "numberScaleUnit": " rb, jt, M",
							      "decimalSeparator": ",",
							      "thousandSeparator": ".",
							      valueFontSize : "10",
							      "rotateValues": "1",
							  },
							  categories: [
								{
								  category: obj.data
								}
							 ],
							 dataset: obj.data5
							},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = obj
										idData = 8
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
						  }).render();
						}
					})
					  
					$.post('<?php echo base_url($headurl.'/projectbyportfolio'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
						
							var caption = "Project By Portfolio";
							var subCaption = "Number of";
							
							var myChart2 = new FusionCharts({
							type: "mscolumn2d",
							renderAt: "chart-containerformance-2",
							width: "100%",
							height: "100%",
							dataFormat: "json",
							dataSource: {
							    chart: {
									caption: caption,
									"subCaption": subCaption,
									"captionFont": "Arial",
									"captionFontSize": "14",
									plottooltext: "<b>$displayValue</b>",
								  "showValues": "0",
								  showlegend: "1",
								  showpercentvalues: "1",
								  legendposition: "bottom",
								  usedataplotcolorforlabels: "1",
								  theme: "fusion",
								  showLabels: "1",
								  labelFontSize:"11",
								  legendItemFontSize:"6",
								  animateClockwise: "1",
								  "pieRadius": "40",
								  "placeValuesInside": "0",
								  "numberScaleValue": "1000,1000,1000",
							      "numberScaleUnit": " rb, jt, M",
							      "decimalSeparator": ",",
							      "thousandSeparator": ".",
							      valueFontSize : "10",
							      "rotateValues": "1",
							  },
							  categories: [
								{
								  category: obj.data
								}
							 ],
							 dataset: obj.data5
							},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = obj
										idData = 6
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
						  }).render();
						}
					})
					
					 
					  
					   $.post('<?php echo base_url($headurl.'/projectbyfunnel'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
						
							var caption = "Sales Funnel";
							var subCaption = "Nominal Rp.";
							
							
					  var myChart2 = new FusionCharts({
						type: "funnel",
						renderAt: "chart-containerformance-5",
						width: "100%",
						height: "100%",
						dataFormat: "json",
						 dataSource: {
						chart: {
							caption: caption,
							 "subCaption": subCaption,
							"captionFont": "Arial",
									"captionFontSize": "14",
							  plottooltext: "<b>$displayValue</b>",
							  "showValues": "1",
							  showlegend: "0",
							  showpercentvalues: "0",
							   "showLabelsAtCenter": "1",
							  legendposition: "bottom",
							  //usedataplotcolorforlabels: "1",
							  theme: "fusion",
							  showLabels: "0",
							  animateClockwise: "1",
							  "pieRadius": "40",
						  "placeValuesInside": "0",
						  "numberScaleValue": "1000,1000,1000",
						  "numberScaleUnit": " rb, jt, M",
						  "decimalSeparator": ",",
						  "thousandSeparator": ".",
						  "valueFontSize" : "9",
						  "baseFontSize" : "9"
					  },
					  data: obj.data
						 },
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = ''
										idData = 3
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
					  }).render();
					  }
					})
	
					  $.post('<?php echo base_url($headurl.'/projectbyam'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
						
							var caption = "Top 10 AM";
							var subCaption = "Nominal Rp.";
							
							
					   var myChart2 = new FusionCharts({
						type: "stackedbar2d",
						renderAt: "chart-containerformance-4",
						width: "100%",
						height: "100%",
						dataFormat: "json",
						dataSource: {
							 chart: {
								caption: caption,
								"captionFont": "Arial",
									"captionFontSize": "14",
								 "subCaption": subCaption,
								 "outCnvBaseFontSize": "10",
								xaxisname: "",
								yaxisname: "",
								theme: "fusion",
								 "showValues": "1",
							  showlegend: "0",
							  "showZeroPlane": "1",
							  "showZeroPlaneValue": "1",
							  showpercentvalues: "0",
							   valueFontSize : "9",
							  legendposition: "right",
							  legenditemfontsize : "10",
							  usedataplotcolorforlabels: "1",
							  theme: "fusion",
							  showLabels: "1",
							  animateClockwise: "1",
							     showYAxisValues : 1,
						    showXAxisValues : 1,
							"rotateValues": "1",
							  },
						 categories: [
								{
								  category: obj.data
								}
							 ],
							 dataset: obj.data5
							},
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = obj
										idData = 9
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
						  }).render();
						}
					})
					
					 $.post('<?php echo base_url($headurl.'/projectbyubis'); ?>',{tahun : tahun, project_tipe : project_tipe, csrf_ortyd_vms_name : "<?php echo $this->security->get_csrf_hash(); ?>"}, function (data) {
						obj = JSON.parse(data);
						if(obj.message == "success"){ 
						
							var caption = "Project by SBU";
							var subCaption = "Number of";
							
							
						var myChart2 = new FusionCharts({
						type: "pie2d",
						renderAt: "chart-containerformance-7",
						width: "100%",
						height: "100%",
						dataFormat: "json",
						 dataSource: {
						chart: {
							caption: caption,
								"captionFont": "Arial",
									"captionFontSize": "14",
								"subCaption": subCaption,
						plottooltext: "<b>$displayValue</b> ",
							  "showValues": "0",
							  showlegend: "0",
							  showpercentvalues: "1",
							  legendposition: "bottom",
							  usedataplotcolorforlabels: "1",
							  theme: "fusion",
							  showLabels: "1",
							  animateClockwise: "1",
							  "pieRadius": "40",
						  "placeValuesInside": "0",
						  "numberScaleValue": "1000,1000,1000",
						  "numberScaleUnit": " rb, jt, M",
						  "decimalSeparator": ",",
						  "thousandSeparator": ".",
						  valueFontSize : "8",
						  legendItemFontSize:"6",
					  },
					  data: obj.data
						 },
							 events: {
									dataPlotClick: function (eventObj, dataObj) {
										categoryLabel = dataObj.categoryLabel
										datasetName = dataObj.datasetName
										titleChart = caption;
										subtitleChart = subCaption;
										objData = ''
										idData = 10
										popupbox1(titleChart,subtitleChart,myChart2,pop,objData,idData,categoryLabel,datasetName)
									}
							  }
					  }).render();
					  }
					})
					 
					 
					});
					
				}
					
					
					</script>

