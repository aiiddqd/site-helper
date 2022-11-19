const dotenv = require("dotenv")
const { Client } = require("@notionhq/client")

dotenv.config()

const databaseId = process.env.NOTION_DB
const notionClient = new Client({ auth: process.env.NOTION_KEY })


async function addItem(title, children) {

    // console.log(title, children)

    try {
        const response = await notionClient.pages.create({
            parent: { 
                "type": "database_id",
                "database_id": databaseId
            },
            properties: {
                Name: {
                    title: [{ type: "text", text: { content: title } }]
                }
            },
            children: [...children]
        })

        response.status = "success"
        return response

    } catch(err){
        console.log(err)
        return {
            status: "error"
        }
    }
}

function prepareChildrenForPage(telegramMessage){

    const template = [
        {
            "object": "block",
            "paragraph": {
                "rich_text": [
                    {
                        "text": {
                            "content": telegramMessage.text
                        }
                    }
                ]
            }
        }
    ]

    // console.log(telegramMessage.text)

    return template;

}

module.exports = { addItem, prepareChildrenForPage }
