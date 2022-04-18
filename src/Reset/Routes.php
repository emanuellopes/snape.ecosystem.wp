<?php

namespace Snape\EcoSystemWP\Reset;

use WP_Error;

/**
 * Class ResetTheme
 *
 * @package Endor\Reset
 */
class Routes
{
    /**
     * ResetTheme constructor.
     */
    public function __construct()
    {
        add_filter('rest_url_prefix', array($this, 'restApiUrlPrefix'));
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('xmlrpc_methods', '__return_empty_array');
        add_action('rest_endpoints', array($this, 'changeUserEndpointPermissions'));
        add_filter('rest_url', array($this, 'restApiUrl'), 10, 1);
    }

    /**
     * Redirect page to 404
     */
    private function goTo404(): void
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part('404');
    }

    /**
     * Change api endpoint from wp-json to api
     *
     * @return string
     */
    public function restApiUrlPrefix(): string
    {
        return 'api';
    }

    public function restApiUrl(string $url): string
    {
        return str_replace(home_url(), site_url(), $url);
    }

    /**
     * Allow editors list the users but not anonymous users.
     *
     * @param  array  $endpoints  List of endpoints.
     *
     * @return array
     */
    public function changeUserEndpointPermissions(array $endpoints): array
    {
        if (isset($endpoints['/wp/v2/users'])) {
            $users_get_route = &$endpoints['/wp/v2/users'][0];
            $users_get_route['permission_callback'] = $this->permissionCallbackHardener(
                $users_get_route['permission_callback']
            );
        }

        if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
            $user_get_route = &$endpoints['/wp/v2/users/(?P<id>[\d]+)'][0];
            $user_get_route['permission_callback'] = $this->permissionCallbackHardener(
                $user_get_route['permission_callback']
            );
        }

        return $endpoints;
    }

    /**
     * Check if user has edit_posts permission and check the old callback for permissions.
     *
     * @param  array|object  $existing_callback  The old callback permission function.
     *
     * @return \Closure
     */
    public function permissionCallbackHardener($existing_callback)
    {
        return function ($request) use ($existing_callback) {
            if (! current_user_can('edit_posts')) {
                return new WP_Error(
                    'rest_user_cannot_view',
                    __('Sorry, you are not allowed to access users.'),
                    array('status' => rest_authorization_required_code())
                );
            }

            return $existing_callback($request); // @phpstan-ignore-line
        };
    }
}
