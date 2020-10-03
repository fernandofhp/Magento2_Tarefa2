<?php
namespace Fhpdev\Pintura\Console\Command;
use Fhpdev\Pintura\Model\Pintura;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Paintshot extends Command
{
    const COR = 'cor';
    const LOJA = 'loja';     
    
    public function __construct() {
        parent::__construct('fhpdev:paintshot');        
    }       

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
    
    private function sobrepor_estilo_css(){
        // 
    }

    private function colorir_bg_btn($cor, $id_loja){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $pintura = $objectManager->get('\Fhpdev\Pintura\Model\Pintura');
        //$pintura = new Pintura;
        // garavar a cor da loja        
        $result = $pintura->load(['id_loja' => $id_loja])
                    ->update(['cor' => $cor])->save(); 
        $this->sobrepor_estilo_css(); 
        return  $result;        
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
            return $this;
        }
        //Efetua a colorização dos buttons
        try {
            $this->colorir_bg_btn($cor, $loja);
        } catch (\Throwable $th) {
            $output->writeln("<error> ERRO: alteração de cor não executada </>");
            $output->writeln("<error> $th </>");
            return $this;
        }
        //Msg no terminal
        $output->writeln('<info> Sucesso!!! </>');
        $output->writeln("<info> Todos os botões da loja ID: [$loja] foram pintados com a cor [$cor] </>");              
        return $this;
    }
}