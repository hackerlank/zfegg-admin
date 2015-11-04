<?php
use Zend\Http\ClientStatic;
use Zend\Json\Json;

include __DIR__ . '/../../../vendor/autoload.php';


$test = new Test;

$test->testGetUsers();

class Test
{
    const HOST = 'http://localhost/zfegg-admin';


    public function testPostOauthPassword()
    {
        /**
         * {
        "access_token": "5311195fbffa91a764c4443810e51644e58654bd",
        "expires_in": 3600,
        "token_type": "Bearer",
        "scope": null,
        "refresh_token": "b8c3f31aa5350b99128e05c0d2f1d3d35e02a817"
        }
         *
         */
        $response = ClientStatic::post(self::HOST . '/oauth', [null],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic MTAwMDp0ZXN0cGFzcw==',
            ],
            <<<EOT
{
    "grant_type": "password",
    "username": "test4",
    "password": "111111"
}
EOT
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testPostOauthAuthorizationCode()
    {
        $response = ClientStatic::post(self::HOST . '/oauth', [null],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic MTAwMDp0ZXN0cGFzcw==',
            ],
            <<<EOT
{
    "redirect_uri": "/oauth/receivecode",
    "client_id": "1000",
    "client_secret": "testpass",
    "code": "35ee26c88a3cd8c8761abe89bf5cc70465841f6a",
    "grant_type" : "authorization_code"
}
EOT
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testGetUsers()
    {
        $response = ClientStatic::get(self::HOST . '/users', [],
            [
                'Accept' => 'application/hal+json',
                'Authorization' => 'Bearer 8642e0f20e1876a9a6d853ec843c5531bd195344',
            ]
        );

        echo ($response->getBody());
    }

    public function testPostUsers()
    {
        $response = ClientStatic::post(
            self::HOST . '/users', [null],
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            <<<EOT
{
    "username": "test4",
    "password": "111111",
    "status": "1",
    "real_name": "Test",
    "email": "test@test.com"
}
EOT
        );



        echo Json::prettyPrint($response->getBody());
    }


    public function testPutUsers()
    {

        $client = new \Zend\Http\Client(self::HOST . '/users/1');
        $client->setMethod('PUT');

        $client->setHeaders([
            'Accept' => 'application/hal+json',
            'Content-Type' => 'application/json',
        ]);
        $client->setRawBody(<<<EOT
{
"email":"test2@test.com"
}
EOT
        );
        $response = $client->send();

        echo Json::prettyPrint($response->getBody());
    }


    public function testGetClients()
    {
        $response = ClientStatic::get(self::HOST . '/clients', [],
            [
                'Accept' => 'application/hal+json',
            ]
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testPostClients()
    {
        $response = ClientStatic::post(
            self::HOST . '/clients', [null],
            [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            <<<EOT
{
    "client_secret": "111111",
    "redirect_uri": "/oauth/receivecode",
    "grant_types": "authorization_code password"
}
EOT
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testGetRoles()
    {
        $response = ClientStatic::get(self::HOST . '/roles', [],
            [
                'Accept' => 'application/hal+json',
            ]
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testDeleteUserRoles()
    {
        $client = new \Zend\Http\Client(self::HOST . '/users/1/roles/2');
        $client->setMethod('DELETE');

        $client->setHeaders([
            'Accept' => 'application/hal+json',
//            'Content-Type' => 'application/json',
        ]);
        $response = $client->send();

        echo $response->toString();
//        echo Json::prettyPrint($response->getBody());
    }

    public function testPostUserRoles()
    {
        $response = ClientStatic::post(self::HOST . '/users/1/roles', [null],
            [
                'Accept' => 'application/hal+json',
                'Content-Type' => 'application/json',
            ],
            json_encode([
                'role_id' => 2,
            ])
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testGetUserRoles()
    {
        $response = ClientStatic::get(self::HOST . '/users/1/roles', [],
            [
                'Accept' => 'application/hal+json',
            ]
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testPutRoleResources()
    {

        $client = new \Zend\Http\Client(self::HOST . '/roles/1/resources/ZfeggAdmin\V1\Rest\AdminRole\Controller::collection');
        $client->setMethod('PUT');

        $client->setHeaders([
            'Accept' => 'application/hal+json',
            'Content-Type' => 'application/json',
        ]);
        $client->setRawBody(json_encode([
            'resource' => 'ZfeggAdmin\\V1\\Rest\\AdminRole\\Controller::collection',
            'privileges' => ['GET','post','Put','delete']
        ]));
        $response = $client->send();

        echo Json::prettyPrint($response->getBody());
    }

    public function testPostRoleResources()
    {

        $response = ClientStatic::post(self::HOST . '/roles/1/resources', [null],
            [
                'Accept' => 'application/hal+json',
                'Content-Type' => 'application/json',
            ],
            json_encode([
                'resource' => 'ZfeggAdmin\\V1\\Rest\\AdminRole\\Controller::collection',
                'privileges' => ['GET','post','Put','delete']
            ])
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testGetRoleResources()
    {
        $response = ClientStatic::get(self::HOST . '/roles/1/resources', [],
            [
                'Accept' => 'application/hal+json',
            ]
        );

        echo Json::prettyPrint($response->getBody());
    }

    public function testGetResources()
    {

        $response = ClientStatic::get(self::HOST . '/resources', [],
            [
                'Accept' => 'application/hal+json',
            ]
        );

        echo Json::prettyPrint($response->getBody());
    }
}

