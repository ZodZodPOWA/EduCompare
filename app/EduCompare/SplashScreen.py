import flet as ft
from main import main_page_view
from login_page import login_page_view
import threading
import time
import socket

def main(page: ft.Page):
    page.title = "Splash"
    page.bgcolor = ft.colors.WHITE
    page.vertical_alignment = ft.MainAxisAlignment.CENTER
    page.horizontal_alignment = ft.CrossAxisAlignment.CENTER

    img = ft.Image(
        src="https://datadice.whf.bz/eduCompare.png",
        width=500,
        height=500,
        fit=ft.ImageFit.CONTAIN,
    )

    progress_bar = ft.ProgressBar(width=400, height=20, color=ft.colors.ORANGE)
    status_message = ft.Text(value="Chargement de l'application...", color=ft.colors.BLUE, size=18)

    page.add(img, progress_bar, status_message)

    # Fonction qui permet de changer la route
    def route_change(route):
        page.views.clear()
        if page.route == "/main":
            page.views.append(main_page_view(page))
        elif page.route == "/login":
            page.views.append(login_page_view(page))
        page.update()

    page.on_route_change = route_change

    # Retirer la view
    def view_pop():
        if page.views:
            page.views.pop()
        if page.views:
            top_view = page.views[-1]
            page.go(top_view.route)

    page.on_view_pop = view_pop

    # Vérifier la connexion internet
    def is_connected():
        try:
            socket.create_connection(("8.8.8.8", 53), timeout=2)
            return True
        except OSError:
            return False

    # Mettre à jour la barre de progression
    def update_progress_bar():
        for i in range(0, 101, 5):
            progress_bar.value = i / 100  # MaJ de la valeur de la barre
            page.update()
            time.sleep(0.1)

    # Changer de route après 3 secondes
    def navigate_after_delay():
        update_progress_bar()  # MaJ de la barre de progression
        if is_connected():
            status_message.value = "Chargement terminé ! Démmarage de l'application..."
            status_message.color = ft.colors.GREEN
            page.update()
            time.sleep(1)
            page.go("/login")
        else:
            status_message.value = "Aucune connexion Internet. Veuillez vérifier votre réseau."
            status_message.color = ft.colors.RED
            page.update()

    threading.Thread(target=navigate_after_delay, daemon=True).start()


ft.app(target=main)
