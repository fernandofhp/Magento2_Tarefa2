<?php
namespace Fhpdev\Pintura\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
//use Magento\Framework\Css\PreProcessor\Adapter\Less\Processor;

class Paintshot extends Command
{
    const COR = 'cor';
    const LOJA = 'loja';     
    
    public function __construct() {
        parent::__construct();
    }   

    /*
    public function mudacor($cor, $storeId){ // storeId = loja
        $tipo = '@button-primary__colo';
        $array = [];
        $array['themeColor'] = "#$cor";
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $store = $om->get('\Magento\Store\Model\StoreManagerInterface')->getStore($storeId);
        if(!$store->isActive())
            return;        
        $storeCode = $store->getCode();
        $str1 = '_'.$storeCode;
        $str2 = 'frontend'.$str1.'.css'; // tipo codigo da loja e css
        $configData = $om->get('Magento\Framework\View\Page\Config');
        //$str3 = $configData->getCssConfigDir().$str2;  // acho que ok
        $str4 = 'Pintura/css/frontend.phtml';        
        //$logger = $om->get('Psr\Log\LoggerInterface');
        //obter caminho de arquivo
        $asset = \Magento\Framework\View\Asset\Repository::createAsset($str4);
        //$asset = $om->get('Magento\Framework\View\Asset\Source'); // idea pegar path da loja[id]
        // $assetpath = $objectManager
        //         ->get('\Magento\Store\Model\StoreManagerInterface')
        //             ->load($id);
        $path = $asset->getPath();
        //parser
        try {
            $parser = new \Less_Parser(
                [ 'relativeUrls' => false,
                    'compress' => $this->appState->getMode() !== State::MODE_DEVELOPER
                ]
            );
            $content = $asset->getContent($asset);
            if (trim($content) === '') {
                return '';
            }
            $temp = new Magento\Framework\Css\PreProcessor\File\Temporary;
            $tmpFilePath = $temp->createFile($path, $content);
            gc_disable();
            $parser->parseFile($tmpFilePath, '');
            $parser->ModifyVars($array); //codigo da Pranjali Goel [webkul]
            $content = $parser->getCss();
            gc_enable();
            return $content;
        } catch (\Throwable $th) {
            //throw $th;
        }

    } */

    protected function configure(){        
        $options = [
			new InputOption(
				self::COR,
				null,
				InputOption::VALUE_REQUIRED,
				'cor'
            ),
			new InputOption(
				self::LOJA,
				null,
				InputOption::VALUE_REQUIRED,
				'loja'
            )
        ];        
        $this->setName('fhpdev:paintshot') 
            ->setDescription('Comando CLI para pintura de botões usando bin/magento for Magento 2')
                ->setDefinition($options);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output){          
        if ($cor = $input->getOption(self::COR)) {
           // testa se cor tem 6 digitos (2 para cada canal RGB)
           // e se todos os dígitos são números hexadecimais
            if(!((strlen($cor) == 6) && (ctype_xdigit($cor)))){ 
                $output->writeln('<error> ERRO: Formato da cor não aceito </>');
                $output->writeln('<error> Utilize 6 digitos hexadecimais (HEX color) </>');
                $output->writeln('<error> Exemplo: 0F5E4D </>');
                return $this;
            }
        } else {
            $cor = 'CCCCCC'; //Cor padrão cinza RGB (204,204,204)
        }
        if ($loja = $input->getOption(self::LOJA)) {    
            //$repo_lojas = new Lojas();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $lojas_ = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $tab_lojas = $lojas_->getStores();  // $this->_storeManager
            //$this->_storeManager->getStore()->getId();
            // testa se a loja existe 
            $ids_existentes = '(';
            $existe = false;
            //$tab_lojas = $repo_lojas->getList();
            foreach ($tab_lojas as $reg_loja) {
                $id_loja = $reg_loja["store_id"];
                $ids_existentes .= " $id_loja";
                if($loja == $id_loja){
                    $existe = true; 
                    break; //encurtando a história...
                }
            }
            $ids_existentes .= ')';
            if (!$existe) {
                $output->writeln("<error> ERRO: A loja de ID: [$loja] não existe </>");
                $output->writeln('<error> IDs de lojas existententes: </>');
                $output->writeln("<error>$ids_existentes </>");
                $output->writeln('<error> Exemplo: 0F5E4D </>');
                return $this;
            }
        } else {
            $output->writeln("<error> ERRO: ID da Loja não foi especificada </>");
            $output->writeln("<error> bin/magento fhpdev:paintshot --cor <cor> --loja <id da loja></>");
        }
        //Efetua a colorização dos buttons
        $this->mudacor($cor, $loja);
        //Msg no terminal
        $output->writeln('<info> Sucesso!!! </>');
        $output->writeln("<info> Todos os botões da loja ID: [$loja] foram pintados com a cor [$cor] </>");              
        return $this;
    }
}