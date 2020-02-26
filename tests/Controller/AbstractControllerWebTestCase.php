<?php
/**
 * @author will <wizarot@gmail.com>
 * @link   http://wizarot.me/
 *
 * Date: 2020/2/26
 * Time: 12:43 下午
 */
declare(strict_types=1);

namespace App\Tests\Controller;

use Safe\Exceptions\JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use function Safe\json_decode;
use function Safe\json_encode;


class AbstractControllerWebTestCase extends WebTestCase
{
    /** @var KernelBrowser */
    protected $client;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->client = static::createClient();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $data
     *
     * @throws JsonException
     */
    protected function JSONRequest(string $method, string $uri, array $data = []): void
    {
        $this->client->request($method, $uri, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
    }

    /**
     * @param Response $response
     * @param int      $expectedStatusCode
     *
     * @return mixed
     * @throws JsonException
     */
    protected function assertJSONResponse(Response $response, int $expectedStatusCode)
    {
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        return json_decode($response->getContent(), true);
    }

}
