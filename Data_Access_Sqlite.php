<?php

/* Clase encargada de gestionar las conexiones a la base de datos */

Class Data_Access_Sqlite extends SQLite3 {

    private $base_datos;
    public $link;
    private $stmt;
    private $array;

    //static $_instance;


    function __construct($ubicacion) {
        $this->open($ubicacion);
	
    }

    /* Evitamos el clonaje del objeto. Patr�n Singleton */
    /* private function __clone() {
      } */

    /* Funci�n encargada de crear, si es necesario, el objeto. Esta es la funci�n que debemos llamar desde fuera de la clase para instanciar el objeto, y as�, poder utilizar sus m�todos */
    /* public static function getInstance() {
      if (!(self::$_instance instanceof self)) {
      self::$_instance = new self();
      }
      return self::$_instance;
      } */

    /* M�todo para ejecutar una sentencia sql */

    public function ejecutar($sql) {
        $this->stmt = $this->query($sql);
        return $this->stmt;
    }
	
	  public function consultarResultados($variable) {
        $listadoDatosRegistros = Array();
		$rows = array();
		$temp = array();
		
		
		
		
       $sql = 'select ' . $variable . ',COUNT(' . $variable . ') AS CANTIDAD  from datos group by ' . $variable;
	   

        $result = $this->query($sql);

        while ($fila = $result->fetchArray(SQLITE3_NUM)) {
			
		$temp = array();
		// the following line will be used to slice the Pie chart
		$temp[] = array('v' => (string) $fila[0]); 

		// Values of each slice
		$temp[] = array('v' => (int) $fila[1]); 
		
		if (!empty($fila[0])) {
		
			$rows[] = array('c' => $temp);
		}
        }

        return $rows;
    }
	
	
		  public function consultarResultadosGraficosHorinzo($variable) {
        $listadoDatosRegistros = Array();
		$rows = array();
		$temp = array();
		$colorIndex=0;
		
		$colors=array("orange", "red", "#8181F7","#04B486","#3ADF00","#00FF00","#FFBF00","#DF0101","#4000FF","#01DF01",);
		
	$rows[] =array('Year', '', array('role' => 'annotation'),array('role' => 'style'));
		
		
       $sql = 'select ' . $variable . ',COUNT(' . $variable . ') AS CANTIDAD  from datos group by ' . $variable;
	   

        $result = $this->query($sql);

        while ($fila = $result->fetchArray(SQLITE3_NUM)) {
		
		if($colorIndex==6)
		{
			$colorIndex=0;
		}
			
		$temp = array();
		// the following line will be used to slice the Pie chart
		$temp[] =  $fila[0]; 

		// Values of each slice
		$temp[] = (int) round($fila[1]*100/130); 
		
		$temp[] = (string) round($fila[1]*100/130,2) . "%"; 
		
		$temp[] =$colors[$colorIndex];
		$colorIndex++;
		
		
		
		if (!empty($fila[0])) {
		
			$rows[] = $temp;
		}
        }

        return $rows;
    }
	
	public function consultarColumnas() {
        $listadoVariables = Array();
        $sql = 'PRAGMA table_info(datos);';

        $result = $this->query($sql);

        while ($fila = $result->fetchArray(SQLITE3_NUM)) {

            array_push($listadoVariables, $fila[1]);

        }

        return $listadoVariables;
    }
	
		public function consultarTextoPregunta($variable) {
        $texto = "";
        $sql = "select texto from preguntas where cod_pregunta='" . $variable . "'";

        $result = $this->query($sql);

        while ($fila = $result->fetchArray(SQLITE3_NUM)) {

		$texto=$fila[0];
  
        }
		$texto=trim(preg_replace('/\s+/', ' ', $texto));
        return $texto;
    }
	
    

}

?>
