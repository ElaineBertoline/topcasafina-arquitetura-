sc_warning = 'off';

/*Tratar variáveis de sessão*/
$Cliente = $_SESSION['usr_Cliente'];
$SubCliente = $_SESSION['usr_SubCliente'];
if(!isset($SubCliente) || empty($SubCliente)){
	$SubCliente != $Cliente;   
}

/*Tratar variáveis do Filtro e WhereClause Geral*/

$whereClauseTransferencias = "";

$formCliente		= "";
$formSubCliente 	= "";
$formDataDe 		= "";
$formDataAte 		= "";
$formPathOrigem 	= "";
$formArquivo 		= "";
$formStatus 		= "";
$formTipoArquivo	= "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$whereClauseTransferencias = "WHERE 1=1";

	$formCliente		= "";
	$formSubCliente 	= $_GET["formSubCliente"];
	$formDataDe 		= $_GET["dataDe"];
	$formDataAte 		= $_GET["dataAte"];
	$formPathOrigem 	= $_GET["path_origem"];
	$formArquivo 		= $_GET["arquivo"];
	$formStatus 		= $_GET["status"];
	$formTipoArquivo	= $_GET["TipoArquivo"];

	if($Cliente != "EBI"){
		$whereClauseTransferencias = "WHERE Cliente = '". $Cliente ."' ";

		if($Cliente == $SubCliente){
			$whereClauseTransferencias .= " AND SubCliente = '". $SubCliente ."'";
		}else{
			if(!empty($formSubCliente)){
				$whereClauseTransferencias .= " AND SubCliente = '$formSubCliente' ";
			}
		}
	}else{
		if(empty($formSubCliente)){
			$formCliente 	= $_GET["formCliente"];
		}

		if(!empty($formCliente)){				
			$whereClauseTransferencias = "WHERE Cliente = '$formCliente' ";
		}

		if(!empty($formSubCliente)){
			$whereClauseTransferencias = "WHERE SubCliente = '$formSubCliente' "; //Substitui o Cliente
		}
	}

	if(!empty($formDataDe)){
		$dateTMP = DateTime::createFromFormat('d/m/Y', $formDataDe);
		$formDataDe = $dateTMP->format('Y-m-d') . " 00:00:00";
		$whereClauseTransferencias .= " AND DataTransferencia >= '$formDataDe' ";
	}else{
		$whereClauseTransferencias .= "AND DataTransferencia >= '". (new \DateTime())->format('Y-m-d') ." 00:00:00'";
	}

	if(!empty($formDataAte)){
		$dateTMP = DateTime::createFromFormat('d/m/Y', $formDataAte);
		$formDataAte = $dateTMP->format('Y-m-d') . " 23:59:59";
		$whereClauseTransferencias .= " AND DataTransferencia <= '$formDataAte' ";
	}else{
		$whereClauseTransferencias .= "AND DataTransferencia <= '". (new \DateTime())->format('Y-m-d') ." 23:59:59'";
	}

	if(!empty($formPathOrigem)){
		$whereClauseTransferencias .= " AND PathOrigem LIKE '%$formPathOrigem%' ";
	}

	if(!empty($formArquivo)){
		$whereClauseTransferencias .= " AND NomeArquivo LIKE '%$formArquivo%' ";
	}

	if(!empty($formStatus)){
		$whereClauseTransferencias .= " AND Status = '$formStatus' ";
	}

	if(!empty($formTipoArquivo)){
		$whereClauseTransferencias .= " AND TipoArquivo = '$formTipoArquivo' ";
	}
}else{
	$whereClauseTransferencias = "WHERE DataTransferencia >= '". (new \DateTime())->format('Y-m-d') ." 00:00:00'";
	$whereClauseTransferencias .= " AND DataTransferencia <= '". (new \DateTime())->format('Y-m-d') ." 23:59:59'";
}

$optionsCliente = "";/*Construindo options de Clientes - INICIO*/

if($Cliente == "EBI"){/* Busca clientes da tabela de clientes */

	// Check for record
	$check_sql = "SELECT Nome FROM cliente";
	sc_lookup(rs, $check_sql);

	$optionsCliente .= "<option value=\"\">Selecione</option>";

	if (isset({rs[0][0]})){// Row found
		foreach ({rs} as $value){
			$optionsCliente .= "<option value=". $value[0];
			if($formCliente == $value[0])	{
				$optionsCliente .= " selected";
			}
			$optionsCliente .= ">". $value[0] ."</option>\n";
		}
	}
}
/*Construindo options de Clientes - FIM*/

/*Construindo options de SubClientes - INICIO*/
$whereClause = " WHERE 1 ";
$retornoNome = "Nome";
$subClienteDisabled = "disabled=true";
$optionsSubCliente = "<option value=\"\">Selecione</option>";

if($SubCliente == "EBI" || ($SubCliente == $Cliente)){	
	$subClienteDisabled = "";
	
	//if($Cliente == "EBI"){
		if(isset($formCliente) && $formCliente <> ''){
			$whereClause .= "AND Cliente = '" . $formCliente . "'";
		}

		// Check for record /* Busca subclientes da tabela de subclientes */
		$check_sql = "SELECT
						   cliente.Nome,
						   subcliente.Nome
						FROM
						   cliente RIGHT OUTER JOIN subcliente ON cliente.Nome = subcliente.Cliente
						".$whereClause."
						ORDER BY
						   cliente.Nome, subcliente.Nome";
		sc_lookup(rs, $check_sql);

		if (isset({rs[0][0]})){ // Row found
			foreach({rs} as $value){
				$optionsSubCliente .= "<option value=". $value[1];
				if($formSubCliente == $value[1]){
					$optionsSubCliente .= " selected";
				}
				$optionsSubCliente .= ">";
				if(!isset($formCliente) || $formCliente == ''){
					$optionsSubCliente .=  $value[0].' - ';
				}	
				$optionsSubCliente .= $value[1];
				$optionsSubCliente .= "</option>\n";
			}
		}
		
	//}
	
}else{
	$whereClause .= "AND Cliente = '" . $Cliente . "'";
	$check_sql = "SELECT
						subcliente.Nome
					FROM
					   cliente RIGHT OUTER JOIN subcliente ON cliente.Nome = subcliente.Cliente
					".$whereClause."
					ORDER BY
					   cliente.Nome, subcliente.Nome";
	sc_lookup(rs, $check_sql);

	if (isset({rs[0][0]})){ // Row found
		foreach({rs} as $value){
			$optionsSubCliente .= "<option value=". $value[0];
			if($formSubCliente == $value[0]){
				$optionsSubCliente .= " selected";
			}
			$optionsSubCliente .= ">";
			$optionsSubCliente .= $value[0];
			$optionsSubCliente .= "</option>\n";
		}
	}
}


/*Construindo options de Clientes - FIM*/


/*Buscando indicadores - INICIO*/

$intEnviados = 0;
$intErros = 0;
$intRegistros = 0;
$intBytes = 0;
$intVelocidade = 0;

/**
* Busca indicadores na tabela de transferencias
*/

// Check for record -- Status
$check_sql = "SELECT COUNT(status), status"
	. " FROM transferencias "
	. $whereClauseTransferencias
	. " group by status order by 2 desc"; //Traz sempre o sent primeiro que o error
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}) && {rs[0][1]} == "sent")     // Row found -- SENT
{
	$intEnviados = {rs[0][0]};
}
else if(isset({rs[0][0]}) && {rs[0][1]} == "error")
{
	$intErros = {rs[0][0]};
}

if (isset({rs[1][0]}))     // Row found -- ERROR
{
	$intErros = {rs[1][0]};
}

// Check for record -- Registros
$check_sql = "SELECT COUNT(*)"
	. " FROM transferencias "
	. $whereClauseTransferencias;
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}))     // Row found
{
	$intRegistros = {rs[0][0]};
}

// Check for record -- Bytes
$check_sql = "SELECT SUM(Size)"
	. " FROM transferencias "
	. $whereClauseTransferencias;
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}))     // Row found
{
	$intBytes = number_format({rs[0][0]},0,",",".");
}

// Check for record -- Velocidade
$check_sql = "SELECT AVG(Rate)"
	. " FROM transferencias "
	. $whereClauseTransferencias;
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}))     // Row found
{
	$intVelocidade = number_format({rs[0][0]},3,",",".");
}

/*Buscando indicadores - FIM*/

/*Populando Gráfico - INICIO -  Busca dados para preencher o gráfico */

$dataGrafico = "";

// Check for record
$check_sql = "SELECT SubCliente, COUNT(SubCliente)
				FROM transferencias "
	. $whereClauseTransferencias
	. " group by SubCliente";
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}))     // Row found
{
	for($i=0;$i < count({rs});$i++)
		{
			if($i != 0)
				$dataGrafico .= ",";
			
			$dataGrafico .= "{label:\"" . {rs[$i][0]} . "\", value:" . {rs[$i][1]} . "}";
		}
}


/*Populando Gráfico - FIM*/

/*Populando Tabela - INICIO*/

$headerTabela = "";
$dataTabela = "";
$oddEven = "odd";

/*Ajustando o header*/
if($Cliente == "EBI")
	{
		$headerTabela .= "<th>Cliente</th>";
	}
$headerTabela .= "<th>SubCliente</th>\n"
	."<th>Data</th>\n"
	."<th>Path Origem</th>\n"
	."<th>Path Destino</th>\n"
	."<th>Arquivo</th>\n"
	."<th>Origem</th>\n"
	."<th>Destino</th>\n"
	."<th>Size</th>\n"
	."<th>Rate</th>\n"
	."<th>Direction</th>\n"
	."<th>Protocolo</th>\n"
	."<th>ErrorMsg</th>\n"
	."<th>Status</th>\n";

/**
* Busca dados para preencher a Tabela
*/

// Check for record
$check_sql = "SELECT Cliente, SubCliente, DATE_FORMAT(DataTransferencia,'%d/%m/%Y %H:%i:%s'), PathOrigem, PathDestino, NomeArquivo, Origem, Destino, Size, Rate, Direction, Protocolo, ErroMsg, Status"
	. " FROM transferencias "
	. $whereClauseTransferencias
	. " ORDER BY DataTransferencia DESC";
sc_lookup(rs, $check_sql);

if (isset({rs[0][0]}))     // Row found
{
	for($i=0;$i < count({rs});$i++)
		{
			$dataTabela .= "<tr class=\"". $oddEven ." gradeA\">";
				
			if($Cliente == "EBI")
				{
					$dataTabela .= "<td>". {rs[$i][0]} ."</td>";
				}
		
			$dataTabela .= "<td>". {rs[$i][1]} ."</td>"
							."<td>". {rs[$i][2]} ."</td>"
							."<td>". {rs[$i][3]} ."</td>"
							."<td>". {rs[$i][4]} ."</td>"
							."<td>". {rs[$i][5]} ."</td>"
							."<td>". {rs[$i][6]} ."</td>"
							."<td>". {rs[$i][7]} ."</td>"
							."<td>". number_format({rs[$i][8]},0,",",".") ."</td>"
							."<td>". number_format({rs[$i][9]},3,",",".") ."</td>"
							."<td>". {rs[$i][10]} ."</td>"
							."<td>". {rs[$i][11]} ."</td>";
		
		    if(!empty({rs[$i][12]}))
				{
					$dataTabela .= "<td style='word-wrap: normal'>". {rs[$i][12]} ."</td>";
				}
			else
				{
					$dataTabela .= "<td></td>";
				}

			$dataTabela	.= "<td>". {rs[$i][13]} ."</td>";
		
			$dataTabela .= "</tr>";
		
			if($oddEven == "odd")
				{
					$oddEven = "even";
				}
			else
				{
					$oddEven = "odd";
				}
		}
}

/*Populando Tabela - FIM*/

?>

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css">
	<link rel="stylesheet" href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css">
	  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 	
  </head>
  <body>
	  
<style type="text/css">

	
	
	@media (min-width: 768px) {
  		#page-wrapper {
    		margin: 0px 0px 0px 0px;
			padding:0px 10px 0px 10px !important;			
			width: 100%;
			height:100%;
			font-size: 18px;	
			font-weight: bold
	
		  }
	
		}
	
	
	@media screen and (min-device-width:1100px) and (max-device-width: 1200px) { 
	
		
    	#formSubCliente, #path_origem, #arquivo, #status, #DataDe, #DataAte, #TipoArquivo {
		font-size: 17px;
		position: fixed;	
		text-align: center;
	
		
		}
	
		
		.col-md-2 {
			width: 13.666667%;
		}
		
	
	
	
	
	#myfirstchart{
	position: fixed;
	
	
			}
		
	}
	
	
	
	
</style>
	  
	
  <div id="wrapper" style="width: 99% !important;">
	
          <div id="page-wrapper" class="col-md-12" >
         <div class="row" style="margin-right: -2px !important; margin-top: 15px;">
				<div class="col-md-12">
                    <div class="panel panel-default" style="margin-bottom: 5px !important;">
                        <div class="panel-heading">
                            EDI | GERENCIAMENTO OPERACIONAL
                        </div>
					    <div class="panel-body" style="width: 99% !important ;  margin-bottom: -15px";>
													
                         <form class="form-inline" id="form-filtro" role="form" method="GET" >
								<?PHP //Inclui seletor de cliente se variável usr_Cliente for igual a EBI
								if($Cliente == "EBI")
									{
								echo "
								<div class=\"form-group\">
									<label class=\"control-label\" for=\"formCliente\">Cliente</label></br>
									<select name=\"formCliente\" class=\"form-control input-sm\" id=\"formCliente\">
										". $optionsCliente ."
									</select>
								</div>
								&nbsp;					
								
								
								";
									}
								?>
														
								<div class="form-group" style= "width:12,5%%  !important;">
									<label  class="control-label";  style="font-size:16px";  for="operacoes" >Operação</label><br />
									<select name="formSubCliente"  style = "height: 34px;" class="form-control input-sm" style = "width: 190px"; id="formSubCliente">			
									
										<?PHP echo $optionsSubCliente; ?>
									</select>
								</div>
							&nbsp;
								<div class="form-group" style="width:12,5%";>
														
									<label class="control-label"; style="font-size:16px";  for="dataDe">Data Início</label><br />
									<input name="dataDe" type="text" size=11 class="form-control date" style = "height: 34px;" id="dataDe" placeholder="dd/mm/aaaa" value="<?PHP if(!empty($formDataDe)) echo date_format(date_create($formDataDe), 'd/m/Y'); ?>" />
								</div>
									&nbsp;
								<div class="form-group" style="width: 12,5%  !important;">
									
									<label class="control-label"; style="font-size:16px";  for="dataAte">Data Fim</label><br />
   								    <input name="dataAte" type="text" size="12" class="form-control date" style = "height: 34px;" id="dataAte" placeholder="dd/mm/aaaa" font-size="16px"; value="<?PHP if(!empty($formDataAte)) echo date_format(date_create($formDataAte), 'd/m/Y'); ?>" />
							
									</div>
							 &nbsp;
								<div class="form-group" style="width: 12,5% !important;">
									<label class="control-label" ;  style="font-size:16px"; for="path_origem">Origem</label><br />
									<input name="path_origem" type="text"  class="form-control" style = "height: 34px;" id="path_origem" value="<?PHP if(!empty($formPathOrigem))  echo $formPathOrigem; ?>">
								</div>
							 &nbsp;
								<div class="form-group" style="width: 12,5% !important;">
									<label class="control-label"; style="font-size:17px"   for="TipoArquivo">Tipo Arquivo</label><br />
									<select name="TipoArquivo" id="TipoArquivo" style="width: 190px; height: 34px;"  class="form-control input-sm">
										<option value="">Todos</option>
										<option value="DOCCOB" <?php if($formTipoArquivo == "DOCCOB") echo "selected";?>>DOCCOB</option>
										<option value="CONEMB" <?php if($formTipoArquivo == "CONEMB") echo "selected";?>>CONEMB</option>
										<option value="CONEMBFAT" <?php if($formTipoArquivo == "CONEMBFAT") echo "selected";?>>CONEMBFAT</option>
										<option value="OCORREN" <?php if($formTipoArquivo == "OCORREN") echo "selected";?>>OCORREN</option> 
									</select>

								</div>
							 &nbsp;
								<div class="form-group" style="width: 12,5% !important;">
									<label class="control-label"; style="font-size:17px" for="status">Status   Transferências</label><br />
									<select name="status"  style="width: 190px; height: 34px" ; class="form-control input-sm"  id="status">
										<option value="">Todos</option>
										<option value="sent" <?PHP if($formStatus == "sent") echo "selected"; ?>>Enviado</option>
										<option value="error" <?PHP if($formStatus == "error") echo "selected"; ?>>Erro</option>
									</select>
								</div>
									&nbsp;
								
								<div class="form-group" style="width: 12,5% !important; align: right">
									<input type="submit" value="Buscar" class="form-control" id="filtro" style="background: #0B62A4; color: #fff; margin-top: 16px; ">
								</div>
							</form>
                        </div>
                        <!-- /.panel-body -->
                  
						</div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->
			  <div class="row">
				<div class="col-md-6">  
               	<div class="panel panel-default">
            
                   <div class="panel-body">
                        <div class="panel-heading text-center"  style= "font-size: 18px" > 
                            Transferências por Parceiro
                     </div>
                       <div class="panel-body">
                            
							<div id="myfirstchart" style="height: 332px;" class="col-md-12"></div>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-md-6">
					<div class="panel panel-default col-md-3" style="padding: 0px !important; width: 49% !important; margin-left: -10px;">
							<div class="panel-heading" >
							Status de Transferências
						</div>
						<div class="panel-body text-center">									
							<div class="col-md-6">
								<div class="alert alert-success" style="padding: 31px !important">
										<div class="row">
											<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;"> 
												<div style="font-size:25px;"><?PHP echo $intEnviados; ?></div>
											</div>
										</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="alert alert-danger" style="padding: 31px !important">
										<div class="row">
											<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
												<div style="font-size:25px;"><?PHP echo $intErros; ?></div>
											</div>
										</div>
								</div>
							</div>
							
						</div>
						<!-- /.panel-body -->
					</div>
					
					<div class="panel panel-default col-md-3" style="padding: 0px !important; width: 49% !important; margin-left: 10px;">
						<div class="panel-heading">
							Total de Transferências
						</div>
						<div class="panel-body text-center">							
							<div class="col-md-12">
								<div class="alert alert-info" style="padding: 31px; !important">
										<div class="row">
											<div class="col-xs-12">
												<div style="font-size:25px; text-align: center;"><?PHP echo $intRegistros; ?></div>
											</div>
										</div>
								</div>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
					<div class="panel panel-default col-md-3" style="padding: 0px !important; width: 49% !important; margin-left: -10px;">
						<div class="panel-heading">
							Velocidade Média em Kbps
						</div>
						<div class="panel-body text-center">
							<div class="col-md-12">
								<div class="alert alert-info" style="padding: 31px; !important">
									<div class="row">
										<div class="col-xs-12">
											<div style="font-size:25px; text-align: center;"><?PHP echo $intVelocidade; ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="panel panel-default col-md-3" style="padding: 0px !important; width: 49% !important; margin-left: 10px;">
						<div class="panel-heading">
							Total de Bytes Transmitidos - Kbs
						</div>
						<div class="panel-body text-center">
							<div class="col-md-12">
								<div class="alert alert-info" style="padding: 31px; !important">
										<div class="row">
											<div class="col-xs-12">
												<div style="font-size:25px; text-align: center;"><?PHP echo $intBytes; ?></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
					<!-- /.panel -->
					
            </div>
            <!-- /.row -->
			<div class="row">
                <!--<div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tabela <div style="text-align:right;"><a href="<?PHP  echo sc_make_link(blank_gera_excel, strSQL=$check_sql); ?>" target="_BLANK">Exportar</a></div>
                        </div>
                        <div class="panel-body">
                            
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<?PHP echo $headerTabela; ?>
							</thead> 
							<tbody>
								<?PHP echo $dataTabela; ?>
							</tbody>
						</table>
							
                        </div>-->
                        <!-- /.panel-body -->
                    <!--</div>-->
                    <!-- /.panel -->
               <!-- </div>-->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
		   </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
	  <!--/div-->
	
	<!-- /continer fluid-->
	
	
	
    <!-- /#wrapper and datepicker -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
	
	<!-- Gráfico -->  
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	
	<!-- DataTables JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-responsive/dataTables.responsive.js"></script>
	  
	<!-- Mascara -->
	<script src="http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
	
    <script type="text/javascript">
		//Construção do Gráfico
		new Morris.Donut({
		element: 'myfirstchart',
		data: [
		<?PHP echo $dataGrafico; ?>
		]
		});
	</script>
	<script>
    $(document).ready(function() {
		//Ajustando a tabela
        $('#dataTables-example').DataTable({
            responsive: true,
			pageLength: 10,
			lengthMenu: [ 10, 20, 45, 75, 100 ],
			pagingType: 'simple_numbers',
			language: {
				paginate: {
					first:    '<<',
					previous: '<',
					next:     '>',
					last:     '>>'
				},
				aria: {
					paginate: {
						first:    'Primeiro',
						previous: 'Anterior',
						next:     'Próximo',
						last:     'Último'
					}
				}
			}
        });
		
		$('#dataTables-example').css({fontSize : '-=4'});
		
		//Datepicker
		$( "#dataDe" ).datepicker({
		dateFormat:"dd/mm/yy"
		});		
		$( "#dataAte" ).datepicker({
		dateFormat:"dd/mm/yy"
		});
		
		//Preenchendo os campos
		$('.date').mask('00/00/0000');
		
		var now = new Date();
		
		var stringTemp = "";
		
		stringTemp = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear();
		
		if($('#dataDe')[0].value == "")
			$('#dataDe')[0].value = stringTemp;
		
		if($('#dataAte')[0].value == "")
			$('#dataAte')[0].value = stringTemp;
    });
    </script>
  </body>
<html>

<?PHP