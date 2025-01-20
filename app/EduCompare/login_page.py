import flet as ft

def login_page_view(page: ft.Page):
    def on_login_click(e):
        username = username_field.value
        password = password_field.value
        if not username or not password:
            error_text.value = "Veuillez entrer un nom d'utilisateur et un mot de passe."
        else:
            if username == "admin" and password == "p4b":
                error_text.color = ""
                page.go("/main")
            else:
                error_text.color = ft.colors.RED
                error_text.value = "Nom d'utilisateur ou mot de passe incorrect."
        page.update()

    username_field = ft.TextField(label="Nom d'utilisateur", width=300, color=ft.colors.BLACK)
    password_field = ft.TextField(label="Mot de passe", password=True, can_reveal_password=True, width=300, color=ft.colors.BLACK)
    error_text = ft.Text(value="", color=ft.colors.RED)
    login_button = ft.ElevatedButton(
        text="Se connecter",
        on_click=on_login_click,
        bgcolor=ft.colors.ORANGE_500,
        color=ft.colors.WHITE,
        width=200,
        height=50,
    )

    return ft.View(
        "/login",
        [
            ft.Image(
                src="https://datadice.whf.bz/img/eduCompare.png",
                width=250,
                height=250,
                fit=ft.ImageFit.CONTAIN,
            ),
            ft.Column(
                [
                    username_field,
                    password_field,
                    login_button,
                    error_text,
                ],
                alignment=ft.MainAxisAlignment.CENTER,
                horizontal_alignment=ft.CrossAxisAlignment.CENTER,
                spacing=20,
            ),
        ],
        vertical_alignment=ft.MainAxisAlignment.CENTER,
        horizontal_alignment=ft.CrossAxisAlignment.CENTER,
        bgcolor=ft.colors.WHITE,
    )
