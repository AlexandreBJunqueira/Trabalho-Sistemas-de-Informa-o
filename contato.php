<!DOCTYPE html>
<html>
<head>
	<title>Contato - PoliCC</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="imagens/capacete.png" type="image/x-icon" />
	<link type="text/css" rel="stylesheet" href="estilo_arquivos/estilo_10.css"/>
	<style>
		body {
			background-color: rgb(5, 24, 42);
			font-family: Arial, sans-serif;
			color: #fff;
			margin: 0;
			padding: 0;
		}

		h1 {
			background-color: rgb(5, 24, 42);
			margin: 0;
			text-align: center;
			font-size: 30px
		}

		form {
			margin: 50px auto;
			width: 50%;
			padding: 20px;
			background-color: rgba(255, 255, 255, 0.8);
			border-radius: 5px;
		}

		label {
			display: block;
			font-size: 20px;
			margin-bottom: 10px;
		}

		input[type="text"],
		input[type="email"],
		textarea {
			display: block;
			margin-bottom: 20px;
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: none;
			background-color: #fff;
			color: #000;
		}

		input[type="submit"] {
			background-color: rgb(5, 24, 42);
			color: #fff;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			font-size: 18px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		input[type="submit"]:hover {
			background-color: white;
			box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
			transform: translateY(-2px);
		}
	</style>
	<style>
		.topo-div {
		background-color: rgb(5, 24, 42);
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
	}

	.menu-topo {
		display: flex;
		flex-direction: row;
		align-items: center;
	}

	.menu-topo a {
		margin-left: 50px;
		color: #fff;
		text-decoration: none;
		font-size: 20px;
		font-weight: bold;
	}

	.menu-topo a:hover {
		text-decoration: underline;
	}

</style>
</head>
<body>
	<div class="global-div"> 
		<div class='topo-div'> 
		
			<h1>Processo seletivo</h1>
			<div class="menu-topo">
				<a href="inicial_10.html">Início</a>
				<a href="https://www.policonsultingclub.com.br/">Sobre</a>
				<a href="contato.php">Contato</a>
			</div>
		</div>
		<form action="#" method="post">
			<label for="nome">Nome:</label>
			<input type="text" id="nome" name="nome" required>
			<label for="email">E-mail:</label>
			<input type="email" id="email" name="email" required>
			<label for="mensagem">Mensagem:</label>
			<textarea id="mensagem" name="mensagem" rows="10" required></textarea>
			<input type="submit" value="Enviar">
		</form>
		<div class='rodape-div'>	
			<p2>
				<hr>
				Poli Consulting Club <br> Telefone para contato: (19) 99230-1959 <br>
				Email: contato@policc.com.br <br>
				Endereço: Av. Prof. Luciano Gualberto, 380 - Butantã, São Paulo - SP, 05508-010 <br>
				Layout de site baseado nas aulas ministradas pelos professores Marcelo Schneck de Paula Pess a e Mauro de Mesquita Spinola, na disciplina Laboratório de
			</p2>