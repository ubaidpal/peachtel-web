<?
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers?o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est? dispon?vel sob a Licen?a GPL dispon?vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc? deve ter recebido uma c?pia da GNU Public License junto com     |
// | esse pacote; se n?o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora??es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo?o Prado Maia e Pablo Martins F. Costa				  |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena??o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Banestes: Fernando Jos? de Oliveira Chagas    |
// +----------------------------------------------------------------------+

// DADOS PERSONALIZADOS - BANESTES
$dadosboleto["carteira"] = "00"; // Carteira do Tipo COBRAN?A SEM REGISTRO (Carteira 00) - N?o ? Carteira 11
$dadosboleto["tipo_cobranca"] = "2";  // 2- Sem registro; 
									  // 3- Caucionada; 
									  // 4,5,6 e 7-Cobran?a com registro
// N?O ALTERAR!
include("include/funcoes_banestes.php"); 
include("include/layout_banestes.php");
?>
