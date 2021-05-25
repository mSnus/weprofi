<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\User;

class TelegramController extends Controller
{
	public function webhook()
	{
		$updates = Telegram::getWebhookUpdate();
		$command = "/start welcome_";
		$command_len = strlen($command);
		if ($updates->message && $updates->message->text && substr($updates->message->text, 0, strlen($command)) == $command) {
			$chat_id = intval($updates->message->chat->id);
			$user_id = intval(substr($updates->message->text, strlen($command)));

			$user = User::find($user_id);
			$user->telegram_id = $chat_id;
			$user->update();
			// file_put_contents(__DIR__."/tg_authorized.txt", date("Y-m-d i:s :")."\n\nCHAT_ID: {$chat_id}, USER: {$user_id}\n\n", FILE_APPEND);

			$response = Telegram::sendMessage([
				'chat_id' => $chat_id,
				'text' => 'Добро пожаловать! '.htmlentities("\xF0\x9F\x94\x94\n\n", ENT_QUOTES, "UTF-8").' Вы были успешно авторизованы.'
			 ]);
		}
		// file_put_contents(__DIR__."/tg_update.txt", date("Y-m-d i:s :")."\n\n".$updates."\n\n", FILE_APPEND);
	}
}
