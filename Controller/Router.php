<?php

namespace Ayastr\Wtrade\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_response;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $custom_url = $this->scopeConfig->getValue('wtrade/general/frontend_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (strpos($identifier, $custom_url) !== false) {
            $request->setModuleName('ayastrwtrade_router')->
            setControllerName('index')->
            setActionName('index');
        } else {
            return false;
        }

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward', ['request' => $request]);
    }
}
