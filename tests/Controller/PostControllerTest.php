<?php
/**
 * @author will <wizarot@gmail.com>
 * @link   http://wizarot.me/
 *
 * Date: 2020/2/26
 * Time: 12:50 下午
 */
declare(strict_types=1);

namespace App\Tests\Controller;

use Safe\Exceptions\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function count;

final class PostControllerTest extends AbstractControllerWebTestCase
{
    /**
     * @throws JsonException
     */
    public function testCreatePost(): void
    {
        // test that sending no message will result to a bad request HTTP code.
        $this->JSONRequest(Request::METHOD_POST, '/api/posts');
        $this->assertJSONResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
        // test that sending a correct message will result to a created HTTP code.
        $this->JSONRequest(Request::METHOD_POST, '/api/posts', ['message' => 'Hello world!']);
        $this->assertJSONResponse($this->client->getResponse(), Response::HTTP_CREATED);
    }

    /**
     * @throws JsonException
     */
    public function testFindAllPosts(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/posts');
        $response = $this->client->getResponse();
        $content = $this->assertJSONResponse($response, Response::HTTP_OK);
        $this->assertEquals(1, count($content));
    }
}
