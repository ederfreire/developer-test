<?php
class Sintegra extends Spider {
	private $pattern;
	public function __construct()
	{
		$this->pattern = '/<td.*class=\"titulo\".*>(.*[\:]?)<\/td>[\r\n\s\t\S ].*<td.*class=\"valor\".*?>(.*?)<\/td>/i';
	}

	public function parseContent($cnpj)
	{
	   $content = $this->getContent($cnpj);
       $content = str_replace("\r\n", PHP_EOL, $content);
       preg_match_all($this->pattern, $content, $matches, PREG_SET_ORDER);

        $data = array_map(function ($item) {
            $key = str_replace(array(':', '&nbsp;'), '', $item[1]);
            $value = str_replace('&nbsp;', '', $item[2]);
            return array(trim(utf8_encode($key))=> $value);
        }, $matches);

        return $data;
	}
	private function getContent($cnpj)
	{
        $content = $this->request(
            'http://www.sintegra.es.gov.br/resultado.php',
            'POST',
            'http://www.sintegra.es.gov.br/index.php',
            array('num_cnpj' => $cnpj, 'num_ie' => '', 'botao' => 'Consultar')
        );

        return $content;
    }
}