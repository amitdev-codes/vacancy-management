<?php

namespace App\Http\Middleware;

use App\Models\Psp_token_payment_credentials;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

class pspkey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $successStatus = 200;
    public $errorStatus = 404;
    public function handle(Request $request, Closure $next)
    {

        $appkey = $request->header('APPKEY');
        $validator = Validator::make($request->json()->all(), [
            'psp_code' => 'required',
        ]);
        if ($validator->fails()) {
            $status = ["status" => false, "status_code" => 422];
            $message = $validator->errors()->all();
            $errorString = implode(",", $message);
            return response()->json(["status" => false, "status_code" => 422, "message" => $errorString], 422);
        } else {
            $psp_code = $request['psp_code'];
        }

        $today = Carbon::now();
        try {
            try {
                Psp_token_payment_credentials::where([['appkey', $appkey], ['psp_code', $psp_code]])->firstOrFail();
                return $next($request);
            } catch (ModelNotFoundException $e) {
                return response()->json(["status" => false, "status_code" => 401, 'message' => 'Invalid App key or PspCode'], 401);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(["status" => false, "status_code" => 404, "message" => 'Clinet Not Found'], 404);
        }

    }
}
