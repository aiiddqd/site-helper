const dotenv = require("dotenv")
const Client = require("@notionhq/client")


dotenv.config()

const notionClient = new Client({ auth: process.env.NOTION_KEY })
const databaseId = process.env.NOTION_DB


// notion()

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

module.exports = notion
