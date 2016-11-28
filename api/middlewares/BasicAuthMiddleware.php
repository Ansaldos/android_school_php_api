<?php
class BasicAuthMiddleware
{
    /**
     * @var Store API_KEY
     */
    private $api_key;

    /**
     * BasicAuthMiddleware constructor.
     * @param $api_key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     *  Basic authentication
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $parameters = $request->getQueryParams();
        $result = array(
            "data" => '',
            "info" => "Wrong API key"
        );
        if(isset($parameters['key']))
        {
            $key = $parameters['key'];
            if($key != $this->api_key){
                return $response->write(json_encode($result));
            }
        } else {
            return $response->write(json_encode(array($result)));
        }

        $response = $next($request, $response);

        return $response;
    }
}