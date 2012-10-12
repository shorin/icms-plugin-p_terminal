<?php
	class p_terminal extends cmsPlugin {
		public function __construct(){
				parent::__construct();
			$this->info['plugin']           = 'p_terminal';
			$this->info['title']            = 'Дополнение для компонента терминал';
			$this->info['description']      = 'Позволяет открыть окно терминала на любой странице сайта';
			$this->info['author']           = 'maix';
			$this->info['version']          = '1.0';
			$this->events[]                 = 'PRINT_PAGE_BODY';
		}
		
		public function install(){
			return parent::install();
		}
		
		public function upgrade(){
			return parent::upgrade();
		}
		
		public function execute($event, $html){
			parent::execute();
			
			$inCore = cmsCore::getInstance();
			$inUser = cmsUser::getInstance();
			
			if ($inUser->is_admin){
				if ($inCore->isComponentInstalled('terminal')){
					$cfg = $inCore->loadComponentConfig('terminal');
					if($cfg['component_enabled']){
						if(!substr_count($_SERVER['REQUEST_URI'],'/terminal')){
							$inCore->loadModel('terminal');
							$model = new cms_model_terminal();
							if ($inUser->sessionGet('is_root')){$terminal_root = 'root';}else{$terminal_root = '';}
							echo '
								<link href="/plugins/p_terminal/p_terminal.css" rel="stylesheet" type="text/css" />
								<script type="text/javascript" src="/plugins/p_terminal/p_terminal.js"></script>
								<script type="text/javascript" src="/components/terminal/terminal.js"></script>
								<div class="terminal_knopka" id="open_terminal" onClick="open_terminal();"></div>
								<div class="terminal_knopka" id="close_terminal" style="display:none;" onClick="close_terminal();"></div>
								<div class="terminal_body" id="terminal_body" style="display:none;" >
									<div onkeypress="return enter_terminal(event);" class="terminal_script"> '.$inUser->nickname.' > 
										<input id="terminal" type="text" value="" autocomplete="off" class="terminal_input" />
										<span id="terminal_root" class="terminal_root">'.$terminal_root.'</span>
									</div>
									<div id="otvet_terminal" class="terminal_otvet">'.$model->getComands().'</div>
								</div>
							';
						}
					}
					else{
						echo '
							<div style="position:fixed;z-index:1001;background:#ff0000;color:$ffffff;padding:5px;">
								Для работы плагина включите компонент "Терминал"
							</div>
						';
					}
				}
				else{
					echo '
						<div style="position:fixed;z-index:1001;width:400px;background:#ff0000;color:$ffffff;padding:5px;">
							Для работы плагина нужен установленный компонент "Терминал"
						</div>
					';
				}
			}
			
			return $html;
		}
	}
?>
