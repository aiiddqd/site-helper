const { Bot } = require("grammy");
const dotenv = require("dotenv");
const { Octokit } = require("octokit")
const notion = require("./src/notion")

dotenv.config()

const github = new Octokit({ auth: process.env.TOKEN_GITHUB })
const bot = new Bot(process.env.BOTTOKEN)

console.log('hello world')

// Handle the /start command.
bot.command("start", (ctx) => {
    ctx.reply("Welcome! Up and running.")
});

// Handle other messages.
bot.on("message", async (ctx) => {
    const message = ctx.message
    const parentMessage = ctx.message.reply_to_message || null

    if(parentMessage === null){
        ctx.reply("no content for add")
        return;
    }

    children = notion.prepareChildrenForPage(parentMessage)

    const response = await notion.addItem(message.text, children)

    ctx.reply("added to notion")
});



bot.hears("ping", async (ctx) => {
    // `reply` is an alias for `sendMessage` in the same chat (see next section).
    await ctx.reply("pong", {
      // `reply_to_message_id` specifies the actual reply feature.
      reply_to_message_id: ctx.msg.message_id,
    });
});



// Start the bot.
bot.start();
