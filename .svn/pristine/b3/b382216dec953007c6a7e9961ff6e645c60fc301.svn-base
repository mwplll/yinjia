<?php
/**
 * smarty 测试页
 */
 
class testSmartyAction extends baseAction
{
	public function execute()
	{
		$this->assign("Name","Fred Irving Johnathan Bradley Peppergill",true);
		$this->assign("FirstName",array("John","Mary","James","Henry"));
		$this->assign("LastName",array("Doe","Smith","Johnson","Case"));
		$this->assign("Class",array(array("A","B","C","D"), array("E", "F", "G", "H"),
			array("I", "J", "K", "L"), array("M", "N", "O", "P")));

		$this->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
			array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));

		$this->assign("option_values", array("NY","NE","KS","IA","OK","TX"));
		$this->assign("option_output", array("New York","Nebraska","Kansas","Iowa","Oklahoma","Texas"));
		$this->assign("option_selected", "NE");

		$this->display('index');
	}
}
?>