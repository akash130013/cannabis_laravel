
            $route_name = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
            if ($route_name == 'store.password.reset') {  //redirecting to the login page of the user
                Auth::guard('store')->logout();
                $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.passwordResetSuccess')];
                return redirect()->route('store.login')->with('success', $http_response_header);
            }