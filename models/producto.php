<?PHP
 class Producto{ 
    
    private  $controlError=array();

	 Private $id;
    Private $Codigo;
    Private $Producto;
    Private $Precio;
    Private $Cantidad;

    Private $pdo;
    Private $idp;
    Private $Accion;
	//Private $pdo;
	

	Public function __construct($pdo){ 
	
		$this->pdo = $pdo;
		
	} //introduceDatos

	public function DatosRequeridos(array $datos){


		 $this->Codigo = $datos["codigo"];
    	 $this->Producto = $datos["producto"];
    	 $this->Precio = $datos["precio"];
    	 $this->Cantidad = $datos["cantidad"];

	}

	public function getCodigo(){
		return $this->Codigo;
	}
    public function getCantidad(){
		return $this->Cantidad;
	}
    public function getPrecio(){
		return $this->Precio;
	}
     public function getProducto(){
		return $this->Producto;
	}
	

	
	public function registrarProductos(){ 
    		
			$data = array(
			"codigo" => "$this->Codigo",
			"producto" => "$this->Producto",
			"precio" => $this->Precio,
         "cantidad" =>$this->Cantidad);
			
			$resultado = $this->pdo->insertSeguro("productos",$data);

			return $resultado;
	}

	public function listarProductos($consulta){ 
    
		  return $this->pdo->Arreglos($consulta);
			
	}

	public function actualizarProducto(){


			$dataActualizar = array(
			"codigo" => "$this->Codigo",
			"producto" => "$this->Producto",
			"precio" => $this->Precio,
         "cantidad" =>$this->Cantidad);

   		$condicion = array(
			"id" => $this->idp); //$this->idp


		if ($this->pdo->updateSeguro("productos", $dataActualizar, $condicion))
   			echo "modificación exitosa";
   	
	}

} 


?>		