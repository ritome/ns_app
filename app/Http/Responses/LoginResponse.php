namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginResponse implements LoginResponseContract
{
/**
* ログイン後のレスポンスを作成
*
* @param \Illuminate\Http\Request $request
* @return \Symfony\Component\HttpFoundation\Response
*/
public function toResponse($request)
{
// デバッグログ
Log::channel('auth')->info('LoginResponse called', [
'wants_json' => $request->wantsJson(),
'ajax' => $request->ajax(),
'headers' => $request->headers->all()
]);

// APIまたはAjaxリクエストの場合
if ($request->wantsJson() || $request->ajax()) {
return new JsonResponse([
'status' => 'success',
'message' => 'ログインに成功しました',
'redirect' => route('dashboard'),
'two_factor' => false
], 200, [
'Content-Type' => 'application/json'
]);
}

// 通常のウェブリクエストの場合
return redirect()->intended(route('dashboard'));
}
}
