class Properties:
    def name(self, column_name, label):
        return {
            column_name: {
                "title": [
                    {
                        "text": {
                            "content": label
                        }
                    }
                ]
            }
        }
    
    def text(self, column_name, *contents):
        return {
            column_name: {
                "rich_text": [
                    {
                        "text": {
                            "content": content
                        }
                    } for content in contents
                ]
            }
        }
    
    def checkbox(self, column_name, boolean: bool):
        return {
            column_name: {
                "checkbox": boolean
            }
        }
    
    def number(self, column_name):
        return {
            column_name: {
                "number": 1999
            }
        }
    
    def select(self, column_name, label):
        return {
            column_name: {
                "select": {
                    "name": label
                }
            }
        }
    
    def multi_select(self, column_name, *labels):
        return {
            column_name: {
                "multi_select": [{
                        "name": label
                    } for label in labels]
            }
        }
    
    def date(self, column_name, start, end):
        # testing on future
        return {
            column_name: {
                "date": {
                    "start": "2022-08-05",
                    "end": "2022-08-10"
                }
            }
        }
    
    def url(self, column_name, url_address):
        return {
            column_name: {
                "url": url_address
            }
        }
    
    def email(self, column_name, email_address):
        return {
            column_name: {
                "email": email_address
            }
        }
    
    def phone(self, column_name, phone_number):
        return {
            column_name: {
                "phone_number": phone_number
            }
        }
    
    def person(self, column_name):
        # testing on future
        return {
            column_name: {
                "people": [
                    {
                        "id": "4af42d2d-a077-4808-b4f7-e960a93fd945"
                    }
                ]
            }
        }
    
    def relation(self, column_name):
        # testing on future
        return {
            column_name: {
                "relation": [
                    {
                        "id": "fbb0a7f2-413e-4728-adbf-281ab14f0c33"
                    }
                ]
            }
        }
