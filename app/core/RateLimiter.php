<?php

namespace App\Core;

use App\Exceptions\RateLimitExceededException;
use App\Services\Cache\SwiftCache;

class RateLimiter
{
    private static $cacheKeyPrefix = "rate_limit_";

    /**
     * Executes a request and checks if the rate limit has been exceeded.
     *
     * @return void
     *
     * @throws RateLimitExceededException If the rate limit has been exceeded.
     */
    public static function execute()
    {
        $ip = getIp();
        $cacheKey = self::$cacheKeyPrefix . $ip;
        if (SwiftCache::has($cacheKey)) {
            $cachedRequest = SwiftCache::get($cacheKey);
            if ($cachedRequest['last_reset'] + 60 < time()) {
                $request = [
                    'last_reset' => time(),
                    'request_count' => 1
                ];
                SwiftCache::set($cacheKey, $request, time() + 60);
            } else {
                $requestCount = $cachedRequest['request_count'];
                $requestCount++;
                $request = [
                    'last_reset' => $cachedRequest['last_reset'],
                    'request_count' => $requestCount
                ];
                SwiftCache::set($cacheKey, $request, time() + 60);
            }
            $rateLimit = Env::get('API_RATE_LIMIT');
            $remainingRequests = $rateLimit - $request['request_count'];

            if ($remainingRequests < 0) {
                throw new RateLimitExceededException("Too many requests. Please try again later.");
            }
        } else {
            $request = [
                'last_reset' => time(),
                'request_count' => 1
            ];
            SwiftCache::set($cacheKey, $request, time() + 60);
            $rateLimit = Env::get('API_RATE_LIMIT');
            $remainingRequests = $rateLimit - 1;

            if ($remainingRequests < 0) {
                throw new RateLimitExceededException("Too many requests. Please try again later.");
            }
        }

        // HTTP yanıt başlıklarına kalan istek hakkını ekleyin
        header("X-RateLimit-Limit: $rateLimit");
        header("X-RateLimit-Remaining: $remainingRequests");
    }
}
