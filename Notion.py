import json
import requests
from Properties import Properties
from DataFormatter import print_data_as_directory, format_data_as_directory

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
            
        def get_table_as_json(self):
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

        
        def property(self, match_string = None):
            res = requests.post(url=self.table_page_read_url, headers=self.headers)
            table_as_json = res.json()
            results = table_as_json["results"]
            properties = [property["properties"] for property in results]

            return properties

        def find_ids_by_similar_text(self, similar_text):
            data = requests.post(url=self.table_page_read_url, headers=self.headers).json()["results"]
            ids = []

            def search_for_text(item):
                if isinstance(item, dict):
                    for value in item.values():
                        if isinstance(value, dict) or isinstance(value, list):
                            search_for_text(value)
                        elif isinstance(value, str) and similar_text in value:
                            id_value = item.get("id")
                            if id_value:
                                ids.append(id_value)
                elif isinstance(item, list):
                    for sub_item in item:
                        if isinstance(sub_item, dict) or isinstance(sub_item, list):
                            search_for_text(sub_item)

            for entry in data:
                search_for_text(entry)

            return ids
        
        def find_ids_by_similar_strict(self, data, similar_text):
            ids = []
            
            def search_for_text(item):
                if isinstance(item, dict):
                    for key, value in item.items():
                        if isinstance(value, dict) or isinstance(value, list):
                            search_for_text(value)
                        elif isinstance(value, str) and similar_text == value:
                            id_value = item.get("id")
                            if id_value:
                                ids.append(id_value)
                elif isinstance(item, list):
                    for sub_item in item:
                        if isinstance(sub_item, dict) or isinstance(sub_item, list):
                            search_for_text(sub_item)
                    
            for entry in data:
                search_for_text(entry)
            
            return ids

        def find_ids_by_similar_insensitive(self, data, similar_text):
            ids = []
            
            def search_for_text(item):
                if isinstance(item, dict):
                    for key, value in item.items():
                        if isinstance(value, dict) or isinstance(value, list):
                            search_for_text(value)
                        elif isinstance(value, str) and similar_text.lower() == value.lower():
                            id_value = item.get("id")
                            if id_value:
                                ids.append(id_value)
                elif isinstance(item, list):
                    for sub_item in item:
                        if isinstance(sub_item, dict) or isinstance(sub_item, list):
                            search_for_text(sub_item)
                    
            for entry in data:
                search_for_text(entry)
            
            return ids

        def find_ids_by_similar_insenspace(self, data, similar_text):
            ids = []
            
            def search_for_text(item):
                if isinstance(item, dict):
                    for key, value in item.items():
                        if isinstance(value, dict) or isinstance(value, list):
                            search_for_text(value)
                        elif isinstance(value, str) and similar_text.replace(" ", "").lower() == value.replace(" ", "").lower():
                            id_value = item.get("id")
                            if id_value:
                                ids.append(id_value)
                elif isinstance(item, list):
                    for sub_item in item:
                        if isinstance(sub_item, dict) or isinstance(sub_item, list):
                            search_for_text(sub_item)
                    
            for entry in data:
                search_for_text(entry)
            
            return ids