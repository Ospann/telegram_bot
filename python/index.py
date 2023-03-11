import telegram
from telegram import KeyboardButton, ReplyKeyboardMarkup

# replace YOUR_TOKEN with the token you received from BotFather
bot = telegram.Bot(token='6170296157:AAGjoKIWQjtMwD_aEE9vYtG0mZSMcZ9toHI')

def start(update, context):
    # create a keyboard with two buttons
    keyboard = [[KeyboardButton('Button 1'), KeyboardButton('Button 2')]]
    reply_markup = ReplyKeyboardMarkup(keyboard)

    # send a message with the keyboard
    context.bot.send_message(chat_id=update.effective_chat.id, text="Choose a button:", reply_markup=reply_markup)

# register the start function with the bot
dispatcher = updater.dispatcher
dispatcher.add_handler(CommandHandler('start', start))

# start the bot
updater.start_polling()