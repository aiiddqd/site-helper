const Bot = require("grammy");
const dotenv = require("dotenv");
const Octokit = require("octokit");
// import notion from "./src/notion";
const Client = require("@notionhq/client")

dotenv.config()

const bot = new Bot(process.env.BOTTOKEN || '')
const github = new Octokit({ auth: process.env.TOKEN_GITHUB })
const notionClient = new Client({ auth: process.env.NOTION_KEY })
const databaseId = process.env.NOTION_DB

notion()
function notion(){
    const title = 'test'
    const data = 

    notionClient.pages.create({
        parent: { 
            database_id: databaseId
        },
        properties: {
            "Name": {
                "title": { 
                    "text": { content: "fssdfsdf" } 
                }
            }
        }
    })

    return true;

}


// Handle the /start command.
bot.command("start", (ctx) => {


    ctx.reply("Welcome! Up and running.")
});
// Handle other messages.
bot.on("message", (ctx) => {

    ctx.reply("Got another message!")
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