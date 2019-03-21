<?php


namespace App\Exceptions;

use Throwable;
use App\Utils\ResponseUtil;

/**
 * Class HttpApiException
 * @package App\Exceptions
 */
class HttpApiException extends \Exception
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $headers;

    /**
     * HttpApiException constructor.
     * @param int            $statusCode
     * @param string         $message
     * @param Throwable|null $previous
     * @param array          $headers
     * @param int            $code
     */
    public function __construct(
        int $statusCode,
        string $message = "",
        Throwable $previous = null,
        array $headers = [],
        int $code = 0
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Render the exception into an HTTP response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json(
            ResponseUtil::makeError(
                $this->getMessage()
            ),
            $this->getStatusCode()
        );
    }
}
