<?php
namespace App\Http\Controllers;

class Carro extends Controller
{
    
    public function get($id = null)
    {
        $response = new \stdClass();
        $response->success = false;
      	$jsonAllCarros = $this->getAllCarros();

     	if ($id === null) {
            $response->success = true;
    		$response->data = json_decode($jsonAllCarros,1);
            return Response(json_encode($response));

    	} else {
                    $arrAllCarros = json_decode($jsonAllCarros,true);
    		        foreach ($arrAllCarros as $key => $value) {
        			    if ($value['id'] == $id) {
                            $response->success = true;
                            $response->data[] = $arrAllCarros[$key];
        				    $response->message = 'Veiculo id'.$id.' encontrado';
        				    break;
        			    } else {
                                    $response->message = 'Veiculo não encontrado';
                        }            
    		        }

    		         return Response(json_encode($response));
    	}

    }

    public function update()
    { 
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
        $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
        $ano = isset($_POST['ano']) ? $_POST['ano'] : null;
    	$response = new \stdClass();
        $response->success = false;
        $newArray = [];

        $arrayAllCarros = json_decode($this->getAllCarros(),1);
 
        foreach ($arrayAllCarros as $key => $value) {
            if ($value['id'] == $id){
                $arrayAllCarros[$key]['nome'] = $nome;
                $arrayAllCarros[$key]['marca'] = $marca;
                $arrayAllCarros[$key]['ano'] = $ano;
            }
        }

        if ($this->putCarInJson($arrayAllCarros)) {

            $response->success = true;
            $response->message = "Veículo alterado"; 
        } else {
                $response->message = "Ocorreu um erro ao tentar editar o veículo!";
        }    
          return json_encode($response);
   
    }

    public function delete($id)
    {
        $response = new \stdClass();
        $response->success = false;
        $newArrayAllCarros = [];
    	$arrAllCarros = json_decode($this->getAllCarros(),1);

        foreach ($arrAllCarros as $key => $value) {
            if ($value['id'] <> $id) {
                 $newArrayAllCarros[] = $arrAllCarros[$key];
                
            }
        }

        if ($this->putCarInJson($newArrayAllCarros)) {
            $response->success = true; 
            $response->message = "Veículo excluído"; 
            } else {
                    $response->message = "Ocorreu um erro ao tentar escluir o veículo!Veículo excluido";
            }

            return json_encode($response);
    }

    public function add()
    { 
    	$carro['nome'] = isset($_POST['nome']) ? $_POST['nome'] : null;
    	$carro['marca'] = isset($_POST['marca'])? $_POST['marca'] : null;
        $carro['ano'] = isset($_POST['ano'])? $_POST['ano'] : null;
        $response = new \stdClass();
        $response->success = false;

        if ($this->carroExiste ($carro)) {
    		if ($this->doAdd($carro)) {
                 $response->message = 'Veiculo adicionado com sucesso!';
                  $response->success = true;
    			            
            } else {
                         $response->message = 'Ocorreu um erro ao tentar cadastrar o veiculo';
            }                   
    			  			  	
            
    	} else {
                     $response->message = 'Veiculo ja existe';
        }

        return json_encode($response);
    	

    }

    public function carroExiste($array)  
    {		
    	$return = true;
    	$allCarrosarray = json_decode($this->getAllCarros(),1); 
        if (count($allCarrosarray) > 1) {
	    	foreach ($allCarrosarray as $key => $value) {     
	    	 	if ($value['nome'] == $array['nome'] && $value['marca'] == $array['marca'] &&  $value['ano'] == $array['ano']) {
		    	 	$return = false;
	    	 		 break;
	    	 	}
	    	} 
        }
    	 return $return; 
    }	
			   
    public function doAdd( $array )
    {	   
        $array['id'] = 0;
    	$allCarrosArray = json_decode($this->getAllCarros(),1);

    	if(count( $allCarrosArray ) > 0) {  
    	     $lastReg = end($allCarrosArray);
    	     $array['id'] = $lastReg['id'] + 1;
    	}

    	array_push($allCarrosArray, $array);
    	if($this->putCarInJson($allCarrosArray))
            return true;
            else
                return false; 
    }

    public function putCarInJson($array)
    {
        $allCarrosarray = json_encode($array);
        if(file_put_contents('carros.json',$allCarrosarray))
            return true;
    }


    public function getAllCarros()
    {
    	$allCarrosJson = file_get_contents('carros.json'); 
    	return $allCarrosJson;
    }
}
