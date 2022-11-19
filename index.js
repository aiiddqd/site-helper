const { Bot } = require("grammy");
const dotenv = require("dotenv");
const { Octokit } = require("octokit")
const notion = require("./src/notion")
// const { Client } = require("@notionhq/client")


dotenv.config()


const github = new Octokit({ auth: process.env.TOKEN_GITHUB })
const bot = new Bot(process.env.BOTTOKEN)

// notion.addItem('dd');
// const databaseId = process.env.NOTION_DB
// const notionClient = new Client({ auth: process.env.NOTION_KEY })
// notion()
// function notion(){
//     notionClient.pages.create({
//         parent: { 
//             "type": "database_id",
//             "database_id": databaseId
//         },
//         properties: {
//             Name: {
//                 title: [{ type: "text", text: { content: "sdfsdf" } }]
//             }
//         }
//     })

//     return true;

// }


// Handle the /start command.
bot.command("start", (ctx) => {
    ctx.reply("Welcome! Up and running.")
});

// Handle other messages.
bot.on("message", (ctx) => {

    const message = ctx.message
    notion.addItem(message.text)
    ctx.reply("added to notion!")
});

bot.hears("ping", async (ctx) => {
    // `reply` is an alias for `sendMessage` in the same chat (see next section).
    await ctx.reply("pong", {
      // `reply_to_message_id` specifies the actual reply feature.
      reply_to_message_id: ctx.msg.message_id,
    });
});


// notion.pages.create({
//     parent: { database_id: databaseId },
//     properties: getPropertiesFromIssue(issue),
//   })


// Now that you specified how to handle messages, you can start your bot.
// This will connect to the Telegram servers and wait for messages.

// Start the bot.
bot.start();

// export DEBUG="grammy*"
// async function createPages(pagesToCreate) {
//     const pagesToCreateChunks = _.chunk(pagesToCreate, OPERATION_BATCH_SIZE)
//     for (const pagesToCreateBatch of pagesToCreateChunks) {
//       await Promise.all(
//         pagesToCreateBatch.map(issue =>
//           notion.pages.create({
//             parent: { database_id: databaseId },
//             properties: getPropertiesFromIssue(issue),
//           })
//         )
//       )
//       console.log(`Completed batch size: ${pagesToCreateBatch.length}`)
//     }
// }