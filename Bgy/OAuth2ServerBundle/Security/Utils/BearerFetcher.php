<?php

namespace Bgy\OAuth2ServerBundle\Security\Utils;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class BearerFetcher
{
    public static function fromRequest(Request $request)
    {
        $tokens = [];
        $tokens[] = self::fromRequestHeaders($request);
        $tokens[] = self::fromFormEncodedBody($request);
        $tokens[] = self::fromQuery($request);

        $tokens = array_filter($tokens, function($value) {
            return null !== $value;
        });

        if (count($tokens) > 1) {

            throw new \LogicException('More than one token were found.');
        }

        if (count($tokens) < 1) {
            // Don't throw exception here as we may want to allow non-authenticated
            // requests.
            return null;
        }

        return reset($tokens);
    }

    private function fromRequestHeaders(Request $request)
    {
        $header = null;
        if (!$request->headers->has('authorization')) {
            // The Authorization header may not be passed to PHP by Apache;
            // Trying to obtain it through apache_request_headers()
            if (function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
                if (is_array($headers)) {
                    // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                    $headers = array_combine(array_map('ucwords', array_keys($headers)), array_values($headers));
                    if (isset($headers['Authorization'])) {
                        $header = $headers['Authorization'];
                    }
                }
            }
        } else {
            $header = $request->headers->get('authorization');
        }

        if (!$header) {
            return null;
        }

        if (!preg_match('/' . preg_quote('Bearer', '/') . '\s(\S+)/', $header, $matches)) {

            return null;
        }

        $token = $matches[1];

        return $token;
    }

    private function fromFormEncodedBody(Request $request)
    {
        if (false === $request->headers->get('content-type')) {

            return null;
        }
        $contentType = $request->headers->get('content-type');

        if (!preg_match('/^application\/x-www-form-urlencoded([\s|;].*)?$/', $contentType)) {

            return null;
        }

        if ('GET' === $request->getMethod()) {

            return null;
        }

        // S2 request only decodes form encoded parameters for PUT, DELETE, PATCH. Because we are not so picky, we can't use Request::$request parameter bag...
        $body = $request->getContent();
        parse_str($body, $parameters);

        if (false === is_array($parameters)) {

            return null;
        }

        if (false === array_key_exists('access_token', $parameters)) {

            return null;
        }

        $token = $parameters['access_token'];

        return $token;
    }

    private function fromQuery(Request $request)
    {
        return $request->query->get('access_token', null);
    }
}
