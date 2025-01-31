import flet as ft
import json
import requests # (pip install requests)

def main_page_view(page: ft.Page):
    def lire_json():
        url = 'https://datadice.whf.bz/EduCompare/json/donnee.json'
        response = requests.get(url)
        if response.status_code == 200:
            return response.json()
        else:
            return {"utilisateur": "Erreur", "age": "N/A", "ville": "N/A"}

    data = lire_json()
    return ft.View(
        "/main",
        [
            ft.Column(
                [
                    ft.Text(f"Nom: {data['utilisateur']}", style="headlineSmall"),
                    ft.Text(f"Age: {data['age']}", style="bodyMedium"),
                    ft.Text(f"Ville: {data['ville']}", style="bodyMedium"),
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
