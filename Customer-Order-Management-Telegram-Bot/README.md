# Customer Order Management Telegram Bot

This is a Telegram bot designed to streamline customer order management by providing quick access to customer data stored in a Google Sheet. The bot offers commands for searching customer orders, monitoring orders by specific parameters, and clearing recent chat messages.

---

## Features
1. **Search Customer Orders:**
   - Search for customer orders using their name or phone number.
   - Returns detailed customer information in a formatted output.

2. **Monitor Orders by SF:**
   - Retrieve all customer orders linked to a specific "KKONTAK(WAJIBISI)" (SF).
   - Displays relevant details in chunks of 10 results per message.

3. **Clear Recent Messages:**
   - Clears the last 10 messages in the chat (useful for group chats).

4. **Help Command:**
   - Displays a list of available commands and their usage.

---

## Commands
### `/search <name or phone>`
Search for customer orders by name or phone number.  
**Example:** `/search Budi` or `/search 823653xxxx`

### `/sf <KKONTAK>`
Retrieve all customer orders linked to a specific "KKONTAK(WAJIBISI)".  
**Example:** `/sf SPMNK95`

### `/clear`
Clears the last 10 messages in the chat.

### `/help` or `/start`
Displays a list of available commands and their usage.

---

## Prerequisites
1. **Python 3.8+**
2. **Telegram Bot API Token**
   - Obtain a bot token from [BotFather](https://core.telegram.org/bots#botfather).
3. **Google Service Account JSON Key**
   - Required for accessing Google Sheets.
   - Follow [this guide](https://gspread.readthedocs.io/en/latest/oauth2.html#service-account) to set up the credentials.
4. **Google Sheet**
   - A Google Sheet with the required columns must be shared with the service account email.
  
---

## Figures
![](https://github.com/robbytbg/Customer-Order-Management-Telegram-Bot/blob/21f5903825c9f7f992b197501195f9b3a0737f7e/Related%20Images/cap1.PNG)

![](https://github.com/robbytbg/Customer-Order-Management-Telegram-Bot/blob/21f5903825c9f7f992b197501195f9b3a0737f7e/Related%20Images/cap2.PNG)

![](https://github.com/robbytbg/Customer-Order-Management-Telegram-Bot/blob/21f5903825c9f7f992b197501195f9b3a0737f7e/Related%20Images/cap3.PNG)
