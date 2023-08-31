import json
import requests

class Notion:
    def __init__(self, auth_token):
        self.auth_token = auth_token
        self.headers = {
            "Authorization": "Bearer " + auth_token,
            "Content-Type": "application/json",
            "Notion-Version": "2022-02-22"
        }

    def database(self, database_id):
        return self.Database(database_id, self.headers)

    class Database:
        def __init__(self, database_id, headers):
            self.database_id = database_id
            self.headers = headers
            # self.properties = Properties()
            self.table_page_url = 'https://api.notion.com/v1/pages'
            self.table_page_read_url = f"https://api.notion.com/v1/databases/{database_id}/query"
            
        def get_raw(self):
            res = requests.post(url=self.table_page_read_url, headers=self.headers)
            return res.json()

        def create_row(self, *properties):
            row_data = {
                "parent": { "database_id": self.database_id },
                "properties": {

                }
            }
            for property in properties:
                row_data["properties"][[key for key in property.keys()][0]] = property[[key for key in property.keys()][0]]

            data = json.dumps(row_data, sort_keys=True, indent=4)
            res = requests.post(url=self.table_page_url, headers=self.headers, data=data)
            
            return res.status_code

        def update_row(self, page_id,*properties):
            row_data = {
                "parent": { "database_id": self.database_id },
                "properties": {
                    
                }
            }
            for property in properties:
                row_data["properties"][[key for key in property.keys()][0]] = property[[key for key in property.keys()][0]]

            data = json.dumps(row_data, sort_keys=True, indent=4)
            res = requests.patch(url=f'{self.table_page_url}/{page_id}', headers=self.headers, data=data)
            
            return res.status_code
        
        def delete_row(self, page_id):
            row_data = {
                "parent": { "database_id": self.database_id },
                "archived": True
            }

            data = json.dumps(row_data, sort_keys=True, indent=4)
            res = requests.patch(url=f'{self.table_page_url}/{page_id}', headers=self.headers, data=data)
            
            return res.status_code