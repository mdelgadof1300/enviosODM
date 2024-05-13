import pandas as pd
import json
from openpyxl import load_workbook
alldata = []

# Do something with the DataFrame, such as print the first few rows
def generador(df,sheet):
    global alldata
    origen = df['origen'][0]
    dir_origen = df['direccion_origen'][0]
    elemJson={
        "id":sheet,
        "origen":origen,
        "ubicacion":dir_origen,
        "destinos":[]
    }
    for index, row in df.iterrows():
        cabecera = row.keys()[5:10]
        if not pd.isnull(row["clave"]):
            elemJson["destinos"].append({"id":row["clave"],"direccion":row["direccion_destino"],"nombre":row['destino'],"precios":{x :row[x] for x in cabecera}})
            alldata.append(elemJson)
'''
    json_str = json.dumps(elemJson, indent=4,ensure_ascii=False)

    # Write the JSON string to a file
    with open('./datos/{0}.json'.format(sheet), 'w',encoding='utf-8') as f:
        f.write(json_str)

'''
if __name__ == "__main__":
    # Read the xlsx file into a pandas DataFrame
    wb = load_workbook('origenes.xlsx')
    excel_file = pd.ExcelFile('origenes.xlsx',engine='openpyxl')

    for sheet_name in excel_file.sheet_names:
        if wb[sheet_name].sheet_state == 'visible':
            df = pd.read_excel('./origenes.xlsx',engine='openpyxl',header=4,sheet_name=sheet_name)
            print(f"Sheet name: {sheet_name}")
            generador(df,sheet_name)

    json_str = json.dumps(alldata, indent=4,ensure_ascii=False)
    # Write the JSON string to a file
    print(alldata)
    with open('./datos.json', 'w',encoding='utf-8') as f:
        f.write(json_str)