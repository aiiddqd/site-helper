import { Bot } from "grammy";
import dotenv from "dotenv";
import { Client } from "@notionhq/client"
import { Octokit, App } from "octokit";

dotenv.config()

const token:string = process.env.BOTTOKEN || '';

const bot = new Bot(token);
const github = new Octokit({ auth: process.env.TOKEN_GITHUB });
const notion = new Client({ auth: process.env.NOTION_KEY });


// You can now register listeners on your bot object `bot`.
// grammY will call the listeners when users send messages to your bot.

// Handle the /start command.
bot.command("start", (ctx) => ctx.reply("Welcome! Up and running."));
// Handle other messages.
bot.on("message", (ctx) => ctx.reply("Got another message!"));

// Now that you specified how to handle messages, you can start your bot.
// This will connect to the Telegram servers and wait for messages.

// Start the bot.
bot.start();

// export DEBUG="grammy*"
