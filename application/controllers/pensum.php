<?php
class Pensum_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{ redirect('pensum/all'); }

	public function all()
	{
		try {
			$this->load->library('grocery_crud');
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
	      	$crud->set_language('spanish');
	      	$crud->set_table('list_pensum')
	      		 ->set_primary_key('id', 'list_pensum')
	      		 ->columns('id', 'creacion', 'estatus', 'carrera', 'departamento', 'accion')
	      		 ->callback_column('accion', array($this,'_callback_columns'));

	      	//$crud->unset_add();
	      	$crud->unset_delete();
	      	$crud->unset_edit();     	
	      	$crud->unset_print();

	     	$output = $crud->render();
	     	$output->js_files['hdghjddtjdtjd'] = base_url().'assets/js/pensum.js';
	     	//$output->css_files['hshshs'] = base_url().'assets/grocery_crud/themes/twitter-bootstrap/css/style.css'; 

	      	$this->smarty->assign('output',$output->output);
		    $this->smarty->assign('css_files',$output->css_files);
		    $this->smarty->assign('js_files',$output->js_files);
		    $this->smarty->display('index.tpl');
		    

		} catch (Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}


	public function _callback_columns($value, $row)
	{
		return '<a id="update-pensum" class="btn" href="#">Modificar</a>';
	}


	public function add()
	{
		$step = array('Seleccionar Carrea', 'Añadir Materia', 'Añadir Electivas');
		$stepConten = array('selectCarre', 'addMateria', 'addElect');

		$this->smarty->assign('title', 'Agregar Pensum');
	    $this->smarty->assign('step', $step);
	    $this->smarty->assign('stepConten', $stepConten);

	    $js_files = array(base_url().'assets/template/js/ace-elements.min.js'); 
		$output = $this->smarty->fetch('wizard.tpl');

	    $this->smarty->assign('output', $output);
	    $this->smarty->assign('css_files','');
	    $this->smarty->assign('js_files', $js_files);
	    $this->smarty->display('index.tpl');
	}

}
?>