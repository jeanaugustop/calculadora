<?php

// Iniciando ou resumindo a sessão
session_start();

function formsCalculo(){
    echo '<form action="" method="get">';
    echo ' Primeiro Numero: <input name="num1" type="text" />';
    echo '<select name="operacao" id="operacao">';
    echo '<option value="soma">+</option>';
    echo '<option value="subtracao">-</option>';
    echo '<option value="multiplicacao">x</option>';
    echo '<option value="divisao">/</option>';
    echo '<option value="potencia">^</option>';
    echo '<option value="fatorial">!</option>';
    echo '</select>';
    echo 'Segundo numero: <input name="num2" type="text" />';
    echo '<br><input type="submit" value="Calcular" />';
    echo '</form>';

    // Botão para salvar na memória
    echo '<form action="" method="post">';
    echo '<input type="submit" name="salvar_memoria" value="Salvar na Memória" />';
    echo '</form>';

    // Botão para recuperar da memória
    echo '<form action="" method="post">';
    echo '<input type="submit" name="recuperar_memoria" value="Recuperar da Memória" />';
    echo '</form>';

    // Lógica para salvar na memória
    if(isset($_POST['salvar_memoria'])) {
        $_SESSION['memoria'] = $_SESSION;
    }

    // Lógica para recuperar da memória
    if(isset($_POST['recuperar_memoria']) && isset($_SESSION['memoria'])) {
        $_SESSION = $_SESSION['memoria'];
    }

    if(isset($_GET["num1"]) && isset($_GET["num2"]) && isset($_GET["operacao"])) {
        $a = $_GET["num1"];
        $b = $_GET["num2"];
        $op = $_GET["operacao"];

        $result = 0;
        // Realiza o cálculo conforme a operação selecionada
        switch($op) {
            case "soma":
                $result = soma($a, $b);
                echo "$a + $b = $result";
                break;
            case "subtracao":
                $result = subtracao($a, $b);
                echo "$a - $b = $result";
                break;
            case "multiplicacao":
                $result = multiplicacao($a, $b);
                echo "$a x $b = $result";
                break;
            case "divisao":
                $result = divisao($a, $b);
                echo "$a / $b = $result";
                break;
            case "potencia":
                $result = potencia($a, $b);
                echo "$a ^ $b = $result";
                break;
            case "fatorial":
                $result = fatorial($a);
                echo "$a ! = $result";
                break;
            default:
                echo "Operação inválida!";
        }

        // Adiciona a operação ao histórico com símbolos correspondentes
        $operacaoSimbolo = '';
        switch($op) {
            case "soma":
                $operacaoSimbolo = '+';
                break;
            case "subtracao":
                $operacaoSimbolo = '-';
                break;
            case "multiplicacao":
                $operacaoSimbolo = 'x';
                break;
            case "divisao":
                $operacaoSimbolo = '/';
                break;
            case "potencia":
                $operacaoSimbolo = '^';
                break;
            case "fatorial":
                $operacaoSimbolo = '!';
                break;
        }
        // Adiciona a operação ao histórico
        $historico = array(
            "num1" => $a,
            "num2" => $b,
            "operacao" => $operacaoSimbolo,
            "resultado" => $result
        );
        $_SESSION['historico'][] = $historico;
    }

    // Botão para limpar o histórico, incluindo o último cálculo
    echo '<form action="" method="post">';
    echo '<input type="submit" name="limpar" value="Limpar Histórico" />';
    echo '</form>';

    // Lógica para limpar o histórico, incluindo o último cálculo
    if(isset($_POST['limpar'])) {
        $_SESSION['historico'] = array(); // Limpa todo o histórico
    }

    // Exibir o histórico
    if(isset($_SESSION['historico']) && count($_SESSION['historico']) > 0) {
        echo '<h2>Histórico</h2>';
        echo '<ul>';
        foreach($_SESSION['historico'] as $item) {
            echo '<li>';
            echo "{$item['num1']} {$item['operacao']} {$item['num2']} = {$item['resultado']}";
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Nenhum cálculo realizado ainda.</p>';
    }
}

// Função para realizar a soma
function soma($a, $b) {
    return $a + $b;
}

// Função para realizar a subtração
function subtracao($a, $b) {
    return $a - $b;
}

// Função para realizar a multiplicação
function multiplicacao($a, $b) {
    return $a * $b;
}

// Função para realizar a divisão
function divisao($a, $b) {
    if($b == 0) {
        return "Erro: Divisão por zero!";
    } else {
        return $a / $b;
    }
}

// Função para realizar a potência
function potencia($a, $b) {
    return pow($a, $b);
}

// Função para calcular o fatorial
function fatorial($num) {
    if($num < 0) {
        return "Erro: Não é possível calcular o fatorial de números negativos!";
    } elseif($num == 0) {
        return 1;
    } else {
        return $num * fatorial($num - 1);
    }
}

?>