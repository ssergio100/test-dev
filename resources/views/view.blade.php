<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="cache-control" content="no-store, no-cache, must-revalidate, Post-Check=0, Pre-Check=0">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">

<html>
	<head>
		<title>Lista</title>
		<style type="text/css">
			table{
				padding-bottom: 20px;margin-top: 20px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron" style="text-align: center"><h2>Veículos</h2></div>
			<div id="geral-message" class="alert alert-info" style="display: none;">Aguarde...</div>
			<div id="toolbar">
			<div class="col-md-3" style="padding-bottom: 5px;">
		  		<div class="input-group">
			      <input type="text" class="form-control"  id="search" placeholder="Digite o ID para buscar">
			      <span class="input-group-btn">
			        <button class="btn btn-default" id="btn-search" type="button">Buscar</button>
			      </span>
			    </div>
			</div>
			<div class="col-md-3" style="padding-bottom: 5px;">
			<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalAdd">+ Adicionar</button>
			</div>
			</div>
			<table class="table" id="car-table"  data-toolbar="#toolbar">
				<thead>
					<tr>
						<th data-field="id">#Id</th>
						<th data-field="nome" data-sortable="true" data-align="left">Modelo</th>
						<th data-field="marca" data-sortable="true" data-align="left">Marca</th>
						<th data-field="ano" data-sortable="true" data-align="left">Ano</th>
						<th data-formatter="operateFormatter" data-events="operateEvents" data-align="center">ações</th>
					</tr>	
				</thead>			
			</table>
			
		</div>


		<!-- Modal -->
		<div id="modalAdd" class="modal fade" role="dialog">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h4 class="modal-title">Adicionar novo veiculo</h4>
		                <div class="alert" id="form-message" style="display: none;"></div>
		            </div>
		            <form>
		                <div class="modal-body">
		                    <div class="form-group">
		                        <label for="nome">Modelo</label>
		                        <input type="text" maxlength="25" class="form-control" id="nome" placeholder=" ex: fusca" required ='true'> 
		                    </div>
		                     <div class="form-group">
		                        <label for="ano">Ano</label>
		                        <input type="number" maxlength="4" class="form-control" id="ano" placeholder="ex: 1975" required ='true'> 
		                    </div>
		                    <div class="form-group">
		                        <label for="marca">Marca</label>
		                        <select class="form-control" id="marca" required='true'> 
		                            <option value="">Selecione</option>
		                        </select>
		                    </div>
		                </div>
		                <div class="modal-footer">
		                    <button type="bu" class="btn btn-default" id='adicionar'>Adicionar</button>
		                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		                </div>
		                <input type="hidden" id="id">
		                <input type="hidden" id="_method" name='_method' value="POST">
		            </form>
		        </div>
		    </div>
		</div>
		<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
		 		load();
				$('#car-table').bootstrapTable({});  
				$.getJSON( "marcas.json", function( data ) {
		  			var items = [];
		  			$.each( data, function( key, val ) {
		    			items.push( "<option id='" + val.nome + "'>" + val.nome + "</option>" );
		  			});
		 
		  			$('#marca').append(items);
				});

			});
			var $table = $('#car-table');
			
			function operateFormatter(value, row, index) {
		        return [
		            '<a class="edit ml10" href="javascript:void(0)" title="Editar">',
		            '<i class="glyphicon glyphicon-edit"></i> ',
		            '</a>',
		            '<a class="remove ml10" href="javascript:void(0)" title="Remover">',
		            '<i class="glyphicon glyphicon-remove"></i>',
		            '</a>'
		        ].join('');
		    }

		    window.operateEvents = {
		        'click .edit': function (e, value, row, index) {
		                editar(row['id'],row['nome'],row['marca'],row['ano']);
		        },
		        'click .remove': function (e, value, row, index) {

		               deletar(row['id']);
		        }
		    };

			$('#adicionar').on('click', function(e) {
				 e.preventDefault();
				
		  
				 	var name = $('input#nome').val();
		         	var marca = $('select#marca').val();
		         	var ano = $('input#ano').val();

		         	var n = ano.length; 
		         	$( "#nome" ).css('background-color','white');
		         	$( "#marca" ).css('background-color','white');

		         	if (name == '') {
		         		$( "#nome" ).css('background-color','yellow');
		         		return false;
		         	}

		         	if (marca == '') {
		         		$( "#marca" ).css('background-color','yellow');
		         		return false;
		         	}

		         	if (ano == '' || n > 4) {
		         		$( "#ano" ).css('background-color','yellow');
		         		return false;
		         	}
		         	$('#form-message').removeClass().addClass('alert alert-info').html('Aguarde...').fadeIn();
		         	var id = $('input#id').val();
		         	var _method = $('input#_method').val();
		       		var formData = 'nome=' + name + '&marca=' + marca +'&ano='+ano+'&id='+id+'&_method='+_method;
		       
					$.ajax({
				      	type: 'POST',
				      	url: '/test-dev/public/carros',
				      	data: formData,
				      	dataType:'json',
				      	success: function(response) { 
				      		$('#form-message').html(response.message).removeClass();
				      		if(response.success == true){
			     				$('#form-message').addClass('alert alert-success');
			     				$('#geral-message').html('').css('display','none');

			          			load();
			     			} else {
			     					$('#form-message').addClass('alert alert-danger');
			     			}
			      		}
			    	});
			}); 

			function deletar(_id) { 
				var r = confirm("Certeza?");
				if (r == true) {
				  	
					$('#geral-message').removeClass().addClass('alert alert-info').html('Aguarde...').fadeIn();
					$.ajax({
				      	type: 'DELETE',
				      	url: '/test-dev/public/carros/'+_id,
				      	dataType:'json',
				      	success: function(response) { 
				      		$('#geral-message').html(response.message).removeClass();
				      		if (response.success == true) {
			     				$('#geral-message').addClass('alert alert-success');
			          			load();
			     			} else {
			     					$('#geral-message').addClass('alert alert-info');
			     			}
			      		}
			    	});

		    	}
			}

		  	function editar(_id, _nome, _marca, _ano){ 
		   		$('#id').val(_id);
		   		$('#nome').val(_nome);
		   		$('#marca').val(_marca);
		   		$('#ano').val(_ano);
		   		$('#_method').attr('value','PATCH');
		   		$('#adicionar').text('Atualizar');
		   		$('#form-message').html('').css('display','none');
		   		$('.modal-title').text('Alterar veículo');
		   		$('#modalAdd').modal('show');
		 	}

		 	function clearModal(){
		 		$('#id').val('');
		   		$('#nome').val('');
		   		$('#marca').val('');
		   		$('#ano').val('');
		   		$('#_method').val('POST');
		   		$('#adicionar').text('Cadastrar');
		   		$('.modal-title').text('Cadastrar veículo');
		   		$('#marca').val('');
		   		$('#form-message').css('display','none');

		 	}


			$('#btn-search').click(function() {
		  		var id = $('#search').val(); 
		  		if (!id) {
		  			var uri ='/test-dev/public/carros';
		  			$('#geral-message').css('display','none');

		  		} else {
		  			var uri = '/test-dev/public/carros/'+id;
		  		}

				$('#geral-message').css('display','block');
		   		$.ajax({
			        type: 'get',
			        url: uri,
			        dataType:'json',
			        success: function(response) { 
			          	$('#geral-message').html(response.message);
			           		if (response.data){
			              		
			               		reload(response.data);
			            	} 
			        } 
		    	}); 
			});

		 	function reload(data){ 
		 		clearModal();
		         $('#car-table').bootstrapTable("load", data);
		    }
		  
		  	function load(){

		        $.getJSON( "/test-dev/public/carros", function( data ) {
		        	$('#car-table').bootstrapTable("load", data.data);
		    	});
		    }

		    $('#modalAdd').on('hidden.bs.modal', function () {
    			clearModal();
			})
		</script>
	</body>
</html>