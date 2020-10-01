<?php
namespace Magento\Framework\Css\PreProcessor\Adapter\Less;
 
 use Magento\Framework\App\State;
 use Magento\Framework\Css\PreProcessor\File\Temporary;
 use Magento\Framework\Phrase;
 use Magento\Framework\View\Asset\ContentProcessorException;
 use Magento\Framework\View\Asset\ContentProcessorInterface;
 use Magento\Framework\View\Asset\File;
 use Magento\Framework\View\Asset\Source;
 use Psr\Log\LoggerInterface;   
 
 class Processor implements ContentProcessorInterface {private $logger;private $appState;      private $assetSource;      private $temporaryFile;
 
    public function __construct( LoggerInterface $logger,State $appState,
                Source $assetSource, Temporary $temporaryFile ) {
        $this->logger = $logger;
        $this->appState = $appState;
        $this->assetSource = $assetSource;
        $this->temporaryFile = $temporaryFile;
    }
 
     public function processContent(File $asset){        //$array = [];        //$array['themeColor'] = '#ffffff';        //$array['color-text'] ='#000000';
        $path = $asset->getPath();
        try {
            $parser = new \Less_Parser(
                [
                    'relativeUrls' => false,
                    'compress' => $this->appState->getMode() !== State::MODE_DEVELOPER
                ]
            );

            $content = $this->assetSource->getContent($asset);

            if (trim($content) === '') {
                return '';
            }

            $tmpFilePath = $this->temporaryFile->createFile($path, $content);

            gc_disable();
            $parser->parseFile($tmpFilePath, '');
            //$parser->ModifyVars($array); //codigo da Pranjali Goel [webkul]
            $content = $parser->getCss();
            gc_enable();

            if (trim($content) === '') {
                $this->logger->warning('Parsed less file is empty: ' . $path);
                return '';
            } else {
                return $content;
            }
        } catch (\Exception $e) {
            throw new ContentProcessorException(new Phrase($e->getMessage()));
        }
     }
 }