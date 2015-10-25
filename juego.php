<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

if(isset($_GET["reset"]))
{
	$_SESSION["matriz_juego"]=$_SESSION["matriz_inicial"];
	$_SESSION["cont"]=0;
	$_SESSION["jugadas"]=$_SESSION["n"]*$_SESSION["m"]*2;
}

if(isset($_GET["reiniciar"]))
{
	session_destroy();
	header("location:index.php");
}

if($_SESSION["inicio"]==true)
{
	$_SESSION["cont"]=0;
	$_SESSION["jugadas"]=$_SESSION["n"]*$_SESSION["m"]*2;
	$tam=$_SESSION["n"]*$_SESSION["m"];
	$numeros[$tam]=0;
	$numeros[0]=0;
	$i=1;
	while($i<$tam)
	{		
		do
		{	
			$enc=false;			
			$numero=rand(1,$tam-1);
			$j=0;
			while($j<$tam && !$enc)
			{
				if($numeros[$j]==$numero)
				{
					$enc=true;
					break;	
				}
				$j++;
			}
			if(!$enc)
			{
				$numeros[$i]=$numero;
				break;
			}
		}while(true);
		
		$i++;
	}

	$k=0;
	for($i=0;$i<$_SESSION["n"];$i++)
		for($j=0;$j<$_SESSION["m"];$j++)
		{
			$_SESSION["matriz_inicial"][$i][$j]=$numeros[$k];
			$k++;		
		}
		
	$_SESSION["matriz_juego"]=$_SESSION["matriz_inicial"];
	
	$_SESSION["inicio"]=false;	
}

if(isset($_GET["fila"]) && isset($_GET["columna"]) && $_SESSION["cont"]<$_SESSION["jugadas"])
{
	if($_GET["fila"]>0 && $_SESSION["matriz_juego"][$_GET["fila"]-1][$_GET["columna"]]==0)
	{
		$_SESSION["matriz_juego"][$_GET["fila"]-1][$_GET["columna"]]=$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]];
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]]=0;
		$_SESSION["cont"]++;
	}
	else	
	if($_GET["fila"]<$_SESSION["n"]-1 && $_SESSION["matriz_juego"][$_GET["fila"]+1][$_GET["columna"]]==0)
	{
		$_SESSION["matriz_juego"][$_GET["fila"]+1][$_GET["columna"]]=$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]];
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]]=0;
		$_SESSION["cont"]++;
	}
	else
	if($_GET["columna"]>0 && $_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]-1]==0)
	{
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]-1]=$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]];
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]]=0;
		$_SESSION["cont"]++;
	}
	else
	if($_GET["columna"]<$_SESSION["m"]-1 && $_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]+1]==0)
	{
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]+1]=$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]];
		$_SESSION["matriz_juego"][$_GET["fila"]][$_GET["columna"]]=0;
		$_SESSION["cont"]++;
	}
}

if($_SESSION["cont"]>=$_SESSION["jugadas"])
{
	echo "Haz Perdido";
}

$k=0;
$ganador=false;
for($i=0;$i<$_SESSION["n"];$i++)
	for($j=0;$j<$_SESSION["m"];$j++)
	{
		if($_SESSION["matriz_juego"][$i][$j]==$k)
		{
			$ganador=true;			
		}
		else
		{
			$ganador=false;	
		}
		$k++;			
	}
	
	if($ganador)
	{
		echo "Haz Ganado";	
	}
?>
 <form id="form1" name="form1" method="get" action="">
  <p>Jugador: <?php echo $_SESSION["nombre"]; ?></p>
  <p>jugadas restantes: <?php echo $_SESSION["jugadas"]-$_SESSION["cont"]; ?></p>
  <table width="200" border="1">
    <?php
  for($i=0;$i<$_SESSION["n"];$i++)
  {
  ?>
    <tr>
    <?php
	for($j=0;$j<$_SESSION["m"];$j++)
	{
		if($_SESSION["matriz_juego"][$i][$j]==0)
		{
		?>
   	  <td>  </td>
        <?php
		}
		else
		{
		?>
	  <td><a href="juego.php?fila=<?php echo $i;?>&columna=<?php echo $j;?>"><?php echo $_SESSION["matriz_juego"][$i][$j] ?></a></td>
    	<?php
		}
	}
	?>
    </tr>
    <?php
  }
  ?>
</table>
  <p>
    <input type="submit" name="reset" id="reset" value="reset" />
    <input type="submit" name="reiniciar" id="reiniciar" value="reiniciar" />
  </p>
</form>

</body>
</html>