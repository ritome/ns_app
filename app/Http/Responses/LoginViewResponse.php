namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class LoginViewResponse implements LoginViewResponseContract
{
/**
* ログインビューを返す
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Contracts\View\View
*/
public function toResponse($request)
{
return view('auth.login');
}
}


