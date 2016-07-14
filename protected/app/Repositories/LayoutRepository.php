<?php 

namespace App\Repositories;

class LayoutRepository
{
	private static $Style 		= '';
	private static $Script		= '';

	/**
     *     
     * @return Codigo renderizado
     * @tutorial 
     * Lista os estilos de acordo com o chamado
     * $style = LayoutRepository::renderStyle()->tables;
     */
	public static function renderStyle()
	{
		return self::$Style =  (object) array(
			'tables' 	=> '
				<link rel="stylesheet" href="'. self::UrlBase('vendor/datatables-colvis/css/dataTables.colVis.css') .'">
        		<link rel="stylesheet" href="'. self::UrlBase('app/vendor/datatable-bootstrap/css/dataTables.bootstrap.css') .'">
			',			
			'chosen' 	=> '
				<link rel="stylesheet" href="'. self::UrlBase('vendor/chosen_v1.2.0/chosen.min.css') .'">
			',
			'line' => '
				<link rel="stylesheet" href="'. self::UrlBase('vendor/simple-line-icons/css/simple-line-icons.css') .'">
			',
			'calendar' 	=> '
				<link rel="stylesheet" href="'. self::UrlBase('vendor/fullcalendar/dist/fullcalendar.css') .'">
			',
			'form'		=> '
				<link rel="stylesheet" href="'. self::UrlBase('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css').'">
				<link rel="stylesheet" href="'. self::UrlBase('vendor/colorpicker/css/colorpicker.css').'" />
        		<link rel="stylesheet" href="'. self::UrlBase('vendor/bootstrap-timepicker/bootstrap-timepicker.min.css').'"  />
        		<link rel="stylesheet" href="'. self::UrlBase('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css').'">
			'
		);
	}

	/**
     *     
     * @return Codigo renderizado
     * @tutorial 
     * Lista os script de acordo com o chamado
     * $script = LayoutRepository::renderScript()->tables;
     */
	public static function renderScript($id = NULL)
	{
		return self::$Script =  (object) array(
			'tables' 				=> '
				<script src="'. self::UrlBase('vendor/datatables/media/js/jquery.dataTables.min.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/datatables-colvis/js/dataTables.colVis.js') .'"></script>
		        <script src="'. self::UrlBase('app/vendor/datatable-bootstrap/js/dataTables.bootstrap.js') .'"></script>
		        <script src="'. self::UrlBase('app/vendor/datatable-bootstrap/js/dataTables.bootstrapPagination.js') .'"></script>
		        <script src="'. self::UrlBase('app/js/demo/demo-datatable.js') .'"></script>    
			',
			'chosen' 				=> '
				<script src="'. self::UrlBase('vendor/chosen_v1.2.0/chosen.jquery.min.js').'"></script>
			',
			'sparkline' => '
				<script src="'. self::UrlBase('app/vendor/sparklines/jquery.sparkline.min.js') .'"></script>
			',
			'flot' => '
			   <script src="'. self::UrlBase('vendor/Flot/jquery.flot.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/flot.tooltip/js/jquery.flot.tooltip.min.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/Flot/jquery.flot.resize.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/Flot/jquery.flot.pie.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/Flot/jquery.flot.time.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/Flot/jquery.flot.categories.js') .'"></script>
			   <script src="'. self::UrlBase('vendor/flot-spline/js/jquery.flot.spline.min.js') .'"></script>
			   <script src="'. self::UrlBase('app/js/demo/demo-flot.js') .'"></script>
			',
			'skycons' => '
				<script src="'. self::UrlBase('vendor/skycons/skycons.js').'"></script>
			',
			'bootstrapFilestyle' 	=> '
				<script src="'. self::UrlBase('vendor/bootstrap-filestyle/src/bootstrap-filestyle.js').'"></script> 
			',
			'calendar' => '
				<script src="'. self::UrlBase('vendor/fullcalendar/dist/fullcalendar.min.js').'"></script>
   				<script src="'. self::UrlBase('vendor/fullcalendar/dist/gcal.js').'"></script>
   				<script src="'. self::UrlBase('vendor/fullcalendar/dist/pt-br.js').'"></script>
			',
			'form' => '
		        <script src="'. self::UrlBase('vendor/bootstrap-filestyle/src/bootstrap-filestyle.js') .'"></script>	      
		        <script src="'. self::UrlBase('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') .'"></script>		      
		        <script src="'. self::UrlBase('vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/jquery.inputmask/dist/jquery.inputmask.bundle.min.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/jquery.inputmask/jquery.maskedinput.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/bootstrap-wysiwyg/bootstrap-wysiwyg.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/bootstrap-wysiwyg/external/jquery.hotkeys.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/moment/min/moment-with-locales.min.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') .'"></script>
		        <script src="'. self::UrlBase('vendor/colorpicker/js/colorpicker.js') .'"></script>		      
		        <script src="'. self::UrlBase('vendor/bootstrap-timepicker/bootstrap-timepicker.min.js') .'"></script>	
	
			',
			'maps' => '
				<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key='.$id.'&amp;sensor=false"></script>
			',
			'cidadesEstados' => '
				<script type="text/javascript" src="'. self::UrlBase('vendor/google/cidades-estados-1.4-utf8.js') .'"></script>
				<script type="text/javascript">
					$(function() {
					  new dgCidadesEstados({
					    estado: $("#estado").get(0),
					    cidade: $("#cidade").get(0)
					  });
					});
				</script>
			',
			'jqueryUI' => '
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/core.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/widget.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/mouse.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/draggable.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/droppable.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jquery-ui/ui/sortable.js') .'"></script>
				<script src="'. self::UrlBase('vendor/jqueryui-touch-punch/jquery.ui.touch-punch.min.js') .'"></script>
			',
 			'ckeditor' => '
				<script src="'. self::UrlBase('app/vendor/ckeditor/ckeditor.js') .'"></script>
		        <script>
		            CKEDITOR.replace( "'.$id.'", {
		                uiColor: "#E1E1E1",
		                skin: "office2013",
		                
		                    filebrowserBrowseUrl      : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/browse.php?type=files') .'",
		                    filebrowserImageBrowseUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/browse.php?type=images') .'",
		                    filebrowserVideoBrowseUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/browse.php?type=videos') .'",
		                    filebrowserFlashBrowseUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/browse.php?type=flash') .'",
		                    filebrowserUploadUrl      : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/upload.php?type=files') .'",
		                    filebrowserImageUploadUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/upload.php?type=images') .'",
		                    filebrowserVideoUploadUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/upload.php?type=videos') .'",
		                    filebrowserFlashUploadUrl : "'. self::UrlBase('app/vendor/ckeditor/kcfinder/upload.php?type=flash') .'"

		            });
		        </script> 
			'
		);
	}

	/**
     * 
     * @param type $dirFile
     * @return Codigo renderizado
     * @tutorial 
     * Cria um caminho para script
     * $filestype = LayoutRepository::createStyle('app/js/ajax/nome.js');
     */
	public static function createStyle($dirFile)
	{
		return 
		'
			<link rel="stylesheet" href="'. self::UrlBase($dirFile) .'">		         
		';
	}

	/**
     * 
     * @param type $dirFile
     * @return Codigo renderizado
     * @tutorial 
     * Cria um caminho para script
     */
	public static function createScript($dirFile)
	{
		return
		'
			<script src="'. self::UrlBase($dirFile) .'"></script>		         
		';
	}

	 /*
	 * ***************************************
	 * **********  PRIVATE METHODS  **********
	 * ***************************************
	 */

	private static function UrlBase($dirFile)
	{
		return \URL::to($dirFile);
	}


}