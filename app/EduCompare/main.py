import flet as ft
import json

def main_page_view(page: ft.Page):
    # def lire_json():
    #     with open('https://datadice.whf.bz/EduCompare/json/donnee.json', 'r') as file:
    #         data = json.load(file)
    #     return data
    
    # data = lire_json()
    return ft.View(
        "/main",
        [
            ft.Column(
            [
                # ft.Text(f"Nom: {data['utilisateur']}", style="headlineSmall"),
                # ft.Text(f"Age: {data['age']}", style="bodyMedium"),
                # ft.Text(f"Ville: {data['ville']}", style="bodyMedium"),
                ft.Text(f"Bouh")
            ],
            alignment=ft.MainAxisAlignment.CENTER,
            horizontal_alignment=ft.CrossAxisAlignment.CENTER,
            spacing=10,
        )
        ],
        vertical_alignment=ft.MainAxisAlignment.CENTER,
        horizontal_alignment=ft.CrossAxisAlignment.CENTER,
        bgcolor=ft.colors.WHITE,
    )
