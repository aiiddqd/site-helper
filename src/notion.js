const dotenv = require("dotenv")
const { Client } = require("@notionhq/client")

dotenv.config()

const databaseId = process.env.NOTION_DB
const notionClient = new Client({ auth: process.env.NOTION_KEY })

const notion = {

    addItem(title){
        notionClient.pages.create({
            parent: { 
                "type": "database_id",
                "database_id": databaseId
            },
            properties: {
                Name: {
                    title: [{ type: "text", text: { content: title } }]
                }
            }
        })

        return true
    }

}

module.exports = notion
