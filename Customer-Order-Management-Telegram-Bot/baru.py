from telegram import Update
from telegram.ext import Updater, CommandHandler, CallbackContext
import logging
import gspread
from google.oauth2.service_account import Credentials

# Setup logging
logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s', level=logging.INFO)

# Define the scope and credentials for Google Sheets
scope = [""]

creds = Credentials.from_service_account_file("", scopes=scope)
client = gspread.authorize(creds)

# Open the Google Sheet by name
spreadsheet = client.open("")
sheet = spreadsheet.worksheet("")  # Replace with your actual sheet name

# Label to column mapping
column_mapping = {
    "Tanggal": "No",
    "SC": "SC",
    "N. Plggn": "NAMA PELANGGAN",
    "No. HP": "NOPPELANGGAN",
    "Alamat": "ALAMAT",
    "Kkontak": "KKONTAK(WAJIBISI)",
    "Channel":"CHANNEL",
    "ODP Utama": "ODP UTAMA(WAJIBISI)",
    "Mitra": "STO",
    "TL Sektor": "TL SEKTOR",
    "S. Order": "STATUS ORDER (WAJIB ISI)",
    "S. SC": "STATUS SC (WAJIB ISI BILA STATUS CLOSE)",
    "Ket.": "KETERANGAN HD (WAJIB ISI BILA STATUS CLOSE)"
}

def help_command(update: Update, context: CallbackContext):
    help_text = (
        "Ini merupakan Bot yang membantu Anda dalam hal berikut:\n\n"
        "1. Anda dapat mencari Order Pelanggan dengan Command: /search nama/no pelanggan.\n"
        "   Contoh: /search Budi/823653xxxx\n\n"
        "2. Anda dapat monitoring Order per SF dengan Command: /sf nomor sf.\n"
        "   Contoh: /sf SPMNK95\n\n"
        "3. Anda dapat membersihkan 10 percakapan terakhir dengan Command: /clear\n"
    )
    update.message.reply_text(help_text)

def search(update: Update, context: CallbackContext):
    if context.args:
        search_term = ' '.join(context.args).strip().lower()
        try:
            # Get all values from the sheet
            all_values = sheet.get_all_values()
            headers = all_values[0]  # Assumes the first row contains headers
            data = all_values[1:]  # Assumes the rest are data rows

            # Find the index of the "NOPPELANGGAN" and "NAMA PELANGGAN" columns
            try:
                nama_index = headers.index(column_mapping["N. Plggn"])
                nop_index = headers.index(column_mapping["No. HP"])
            except ValueError:
                update.message.reply_text('Required columns not found in the sheet.')
                return

            # Search for the term in either "NOPPELANGGAN" or "NAMA PELANGGAN" columns
            result = next((row for row in data if row[nama_index].strip().lower() == search_term or row[nop_index].strip() == search_term), None)

            if result:
                # Get the values for NOPPELANGGAN and NAMA PELANGGAN
                nop_pelanggan = result[nop_index]
                nama_pelanggan = result[nama_index]

                # Combine them in the required format
                pelanggan_info = f"{nop_pelanggan}/{nama_pelanggan}"

                # Calculate the maximum length of the labels
                max_label_length = max(len(label) for label in column_mapping.keys())

                # Format the details with aligned colons
                details = '\n'.join([f"{label.ljust(max_label_length)}: {result[headers.index(column)]}" for label, column in column_mapping.items()])
                formatted_details = f"```\n{details}\n```"
                
                # Send the response with the pelanggan_info at the top
                update.message.reply_text(f"{pelanggan_info}\n{formatted_details}", parse_mode='MarkdownV2')
            else:
                update.message.reply_text(f'No details found for "{search_term}".')
        except Exception as e:
            logging.error(f'Error in search: {e}')
            update.message.reply_text('An error occurred while searching.')
    else:
        update.message.reply_text('Please provide a name or phone number to search for.')

def sf(update: Update, context: CallbackContext):
    if context.args:
        kkontak_term = ' '.join(context.args).strip().lower()
        try:
            # Get all values from the sheet
            all_values = sheet.get_all_values()
            headers = all_values[0]  # Assumes the first row contains headers
            data = all_values[1:]  # Assumes the rest are data rows

            # Find the index of the "KKONTAK(WAJIBISI)" column
            try:
                kkontak_index = headers.index(column_mapping["Kkontak"])
            except ValueError:
                update.message.reply_text('Column "KKONTAK(WAJIBISI)" not found in the sheet.')
                return

            # Search for all rows where the "KKONTAK(WAJIBISI)" matches the term
            results = [row for row in data if row[kkontak_index].strip().lower() == kkontak_term]

            if results:
                # Define the required labels and their corresponding column names
                sf_mapping = {
                    "No. SC": "SC",
                    "Nama": "NAMA PELANGGAN",
                    "No. HP": "NOPPELANGGAN",
                    "S. SC": "STATUS SC (WAJIB ISI BILA STATUS CLOSE)",
                    "Ket.": "KETERANGAN HD (WAJIB ISI BILA STATUS CLOSE)"
                }

                # Calculate the maximum length of the labels for alignment
                max_label_length = max(len(label) for label in sf_mapping.keys())

                # Split the results into chunks of 10
                chunks = [results[i:i + 10] for i in range(0, len(results), 10)]

                # Loop through each chunk and send a separate message
                for chunk in chunks:
                    details_list = []
                    for result in chunk:
                        details = '\n'.join(
                            [f"{label.ljust(max_label_length)}: {result[headers.index(column)].strip()}" for label, column in sf_mapping.items()]
                        ).strip()  # Trim any leading/trailing spaces and newlines from the entire details string
                        details_list.append(details)
                    
                    formatted_details = '\n\n'.join(details_list).strip()  # Trim any extra newlines between entities
                    formatted_details = f"```\n{formatted_details}\n```"
                    
                    update.message.reply_text(formatted_details, parse_mode='MarkdownV2')
            else:
                update.message.reply_text(f'No details found for "{kkontak_term}".')
        except Exception as e:
            logging.error(f'Error in sf: {e}')
            update.message.reply_text('An error occurred while searching.')
    else:
        update.message.reply_text('Please provide a KKONTAK to search for.')

# /clear command to delete chat messages
def clear_command(update: Update, context: CallbackContext):
    chat_id = update.message.chat_id

    # Delete all messages from the chat (for group chats, the bot must have admin privileges)
    for i in range(1, 11):  # Deleting the last 10 messages as an example
        try:
            context.bot.delete_message(chat_id=chat_id, message_id=update.message.message_id - i)
        except:
            continue  # Ignore errors, like if the message doesn't exist or was already deleted

    update.message.reply_text("10 Latest Chat has been cleared.")

def main():
    # Create the Updater and pass it your bot's token.
    updater = Updater("", use_context=True)

    # Register the help command
    dp = updater.dispatcher
    dp.add_handler(CommandHandler("start", help_command))
    dp.add_handler(CommandHandler("help", help_command))

    # Register the search command
    dp.add_handler(CommandHandler("search", search))
    # Register the search by contact command
    dp.add_handler(CommandHandler("sf", sf))
    # Register the /clear command
    dp.add_handler(CommandHandler("clear", clear_command))

    # Start the Bot
    updater.start_polling()
    updater.idle()

if __name__ == "__main__":
    main()
